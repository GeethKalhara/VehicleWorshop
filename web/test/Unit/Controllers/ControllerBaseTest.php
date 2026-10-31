<?php

declare(strict_types=1);

namespace Vwork\Web\Test\Unit\Controllers;

use Override;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\Attributes\TestWith;
use PHPUnit\Framework\TestCase;
use Random\Randomizer;
use Vwork\Shared\Collections\ImmutableRegistry;
use Vwork\Shared\Collections\IRegistry;
use Vwork\Web\Http\Request\Request;
use Vwork\Web\Test\Stubs\ControllerBaseStub;
use Vwork\Web\Utils\AssetParser;
use Vwork\Web\Utils\CsrfToken;
use Vwork\Web\Utils\IUtility;
use Vwork\Web\Utils\View;
use Vwork\Web\WebError;

final class ControllerBaseTest extends TestCase
{
    private const string SECRET = 'q29bvc9tqccb43xZLmmpor2imn7ewqdf2v43x';

    /** @var array<mixed, mixed> */
    private array $server;

    #[Override]
    protected function setUp(): void
    {
        parent::setUp();
        $this->server = $_SERVER;
    }

    #[Override]
    protected function tearDown(): void
    {
        $_SERVER = $this->server;
        parent::tearDown();
    }

    private static function csrf(): CsrfToken
    {
        return new CsrfToken(self::SECRET, new Randomizer());
    }

    private static function controller(): ControllerBaseStub
    {
        $registry = new ImmutableRegistry(
            [
                View::class => static fn (IRegistry $r) => new View('web/test/Fixtures/Views'),
                CsrfToken::class => static fn (IRegistry $r) => self::csrf(),
                AssetParser::class => static fn (IRegistry $r) => new AssetParser('web/test/Fixtures/Assets/assets.json')
            ],
            [IUtility::class]
        );
        return new ControllerBaseStub($registry);
    }

    private static function request(?string $session = 'sess-1', ?string $csrfHeader = null): Request
    {
        $_SERVER = ['REQUEST_METHOD' => 'GET', 'REQUEST_URI' => '/', 'REMOTE_ADDR' => ''];
        if ($session !== null) {
            $_SERVER['HTTP_COOKIE'] = "session_token={$session}";
        }
        if ($csrfHeader !== null) {
            $_SERVER['HTTP_X_CSRF_TOKEN'] = $csrfHeader;
        }

        return Request::fromGlobals();
    }

    // ---- view ----

    #[Test]
    public function view_renders_the_template_on_its_own_without_a_layout(): void
    {
        $html = self::controller()->callView(self::request(), 'vars', ['name' => 'Sneze', 'count' => 3]);

        $this->assertSame("Sneze has 3 jobs\n", $html);
    }

    #[Test]
    public function view_wraps_the_template_in_the_layout(): void
    {
        $html = self::controller()->callView(self::request(), 'vars', ['name' => 'Sneze', 'count' => 3, 'title' => 'Jobs'], 'lay');

        $this->assertMatchesRegularExpression(
            '~^<title>Jobs</title>\n<meta name="csrf-token" content="[A-Za-z0-9_-]{86}">\n<main>Sneze has 3 jobs\n</main>\nisolated$~',
            $html,
        );
    }

    #[Test]
    public function view_falls_back_to_a_default_title(): void
    {
        $html = self::controller()->callView(self::request(), 'hello', [], 'lay');

        $this->assertStringStartsWith('<title>No Title</title>', $html);
    }

    #[Test]
    public function view_passes_only_content_title_and_csrf_to_the_layout(): void
    {
        $html = self::controller()->callView(self::request(), 'vars', ['name' => 'Sneze', 'count' => 3], 'lay');

        $this->assertStringEndsWith('isolated', $html);
    }

    #[Test]
    #[TestWith(['sess-1'])]
    #[TestWith([null])] // no session yet: still a token, for the empty id
    public function view_gives_the_template_a_csrf_token_for_this_session(?string $session): void
    {
        $token = self::controller()->callView(self::request($session), 'form');

        $this->assertTrue(self::csrf()->verify($session ?? '', $token));
        $this->assertFalse(self::csrf()->verify('another-session', $token));
    }

    #[Test]
    public function the_template_and_layout_get_the_same_token(): void
    {
        $html = self::controller()->callView(self::request(), 'form', [], 'lay');

        $this->assertMatchesRegularExpression('~content="([^"]+)">\n<main>\1</main>~', $html);
    }

    #[Test]
    public function view_reuses_the_csrf_token_the_request_sent(): void
    {
        $html = self::controller()->callView(self::request(csrfHeader: 'from-header'), 'form', [], 'lay');

        $this->assertMatchesRegularExpression('~content="from-header">\n<main>from-header</main>~', $html);
    }

    #[Test]
    public function data_cannot_override_the_csrf_token(): void
    {
        $token = self::controller()->callView(self::request(), 'form', ['csrf' => 'forged']);

        $this->assertNotSame('forged', $token);
        $this->assertTrue(self::csrf()->verify('sess-1', $token));
    }

    #[Test]
    #[TestWith(['does_not_exist', null])]
    #[TestWith(['hello', 'does_not_exist'])]
    public function view_throws_for_a_missing_template_or_layout(string $template, ?string $layout): void
    {
        $this->expectException(WebError::class);
        self::controller()->callView(self::request(), $template, [], $layout);
    }
}
