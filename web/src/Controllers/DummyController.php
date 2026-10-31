<?php

declare(strict_types=1);

namespace Vwork\Web\Controllers;

use Closure;
use Generator;
use Vwork\Shared\Collections\IRegistry;
use Vwork\Web\Http\Request\Request;
use Vwork\Web\Http\Response\Response;

/**
 * A sample controller: proves a request can travel from the router,
 * through the pipeline, to an action and back.
 *
 * @phpstan-import-type StringMap from IController
 *
 * @author Senira <senirahan@gmail.com>
 */
final readonly class DummyController extends ControllerBase
{
    public function __construct(IRegistry $registry)
    {
        parent::__construct($registry);
    }

    /** @param StringMap $attr */
    #[ControllerAction]
    public function hello(Request $req, array $attr): Response
    {
        return Response::single()->text('Hello');
    }

    /** @param StringMap $attr */
    #[ControllerAction]
    public function dummy(Request $req, array $attr): Response
    {
        $html = $this->view($req, 'dummy/dummy', [
            'title' => 'Dummy Page',
            'message' => 'Hello Sailor!'
        ], 'layouts/blank');

        return Response::single()->html($html);
    }

    /** @param StringMap $attr */
    #[ControllerAction]
    public function dummyhello(Request $req, array $attr): Response
    {
        $html = $this->view($req, 'dummy/hello', $data = [
            'message' => 'Hello Sailor!'
        ]);

        return Response::single()->html($html);
    }

    /** @param StringMap $attr */
    #[ControllerAction]
    public function greeting(Request $req, array $attr): Response
    {
        $view = $this->view;

        /** @return Generator<string, string> */
        $render = static function () use ($view): Generator {
            while (connection_aborted() === 0) {
                yield 'dummy:event' => $view->render('dummy/greeting', [
                    'message' => bin2hex(random_bytes(8))
                ]);

                sleep(2);
            }
        };

        return Response::stream()->html($render());
    }
}
