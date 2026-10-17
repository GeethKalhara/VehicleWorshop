---
name: Industrial Modern Workshop
colors:
  surface: '#f9f9ff'
  surface-dim: '#d3daea'
  surface-bright: '#f9f9ff'
  surface-container-lowest: '#ffffff'
  surface-container-low: '#f0f3ff'
  surface-container: '#e7eefe'
  surface-container-high: '#e2e8f8'
  surface-container-highest: '#dce2f3'
  on-surface: '#151c27'
  on-surface-variant: '#584237'
  inverse-surface: '#2a313d'
  inverse-on-surface: '#ebf1ff'
  outline: '#8c7164'
  outline-variant: '#e0c0b1'
  surface-tint: '#9d4300'
  primary: '#9d4300'
  on-primary: '#ffffff'
  primary-container: '#f97316'
  on-primary-container: '#582200'
  inverse-primary: '#ffb690'
  secondary: '#575e70'
  on-secondary: '#ffffff'
  secondary-container: '#d9dff5'
  on-secondary-container: '#5c6274'
  tertiary: '#006398'
  on-tertiary: '#ffffff'
  tertiary-container: '#00a2f4'
  on-tertiary-container: '#003554'
  error: '#ba1a1a'
  on-error: '#ffffff'
  error-container: '#ffdad6'
  on-error-container: '#93000a'
  primary-fixed: '#ffdbca'
  primary-fixed-dim: '#ffb690'
  on-primary-fixed: '#341100'
  on-primary-fixed-variant: '#783200'
  secondary-fixed: '#dce2f7'
  secondary-fixed-dim: '#c0c6db'
  on-secondary-fixed: '#141b2b'
  on-secondary-fixed-variant: '#404758'
  tertiary-fixed: '#cde5ff'
  tertiary-fixed-dim: '#93ccff'
  on-tertiary-fixed: '#001d32'
  on-tertiary-fixed-variant: '#004b74'
  background: '#f9f9ff'
  on-background: '#151c27'
  surface-variant: '#dce2f3'
  primary-hover: '#EA580C'
  primary-subtle: '#FFF7ED'
  surface-sidebar: '#111827'
  surface-sidebar-hover: '#1F2937'
  canvas: '#F9FAFB'
  surface-card: '#FFFFFF'
  border-default: '#E5E7EB'
  border-input: '#D1D5DB'
  text-primary: '#111827'
  text-secondary: '#6B7280'
  text-inverted: '#FFFFFF'
  text-label: '#374151'
  status-success-text: '#15803D'
  status-success-bg: '#DCFCE7'
  status-warning-text: '#B45309'
  status-warning-bg: '#FEF3C7'
  status-danger-text: '#B91C1C'
  status-danger-bg: '#FEE2E2'
  status-info-text: '#1D4ED8'
  status-info-bg: '#DBEAFE'
  status-neutral-text: '#374151'
  status-neutral-bg: '#F3F4F6'
  skeleton-pulse: '#E5E7EB'
typography:
  headline-h1:
    fontFamily: Inter
    fontSize: 24px
    fontWeight: '600'
    lineHeight: 32px
    letterSpacing: -0.02em
  headline-h2:
    fontFamily: Inter
    fontSize: 18px
    fontWeight: '500'
    lineHeight: 28px
    letterSpacing: 0em
  body-default:
    fontFamily: Inter
    fontSize: 14px
    fontWeight: '400'
    lineHeight: 20px
    letterSpacing: 0em
  body-medium:
    fontFamily: Inter
    fontSize: 14px
    fontWeight: '500'
    lineHeight: 20px
    letterSpacing: 0em
  label-secondary:
    fontFamily: Inter
    fontSize: 12px
    fontWeight: '500'
    lineHeight: 16px
    letterSpacing: 0em
  label-table-header:
    fontFamily: Inter
    fontSize: 12px
    fontWeight: '500'
    lineHeight: 16px
    letterSpacing: 0.05em
  button-text:
    fontFamily: Inter
    fontSize: 14px
    fontWeight: '500'
    lineHeight: 20px
    letterSpacing: 0em
rounded:
  sm: 0.25rem
  DEFAULT: 0.5rem
  md: 0.75rem
  lg: 1rem
  xl: 1.5rem
  full: 9999px
spacing:
  gutter: 1rem
  gutter-desktop: 1.5rem
  margin: 1rem
  margin-desktop: 2rem
  space-xs: 0.5rem
  space-sm: 1rem
  space-md: 1.5rem
  space-lg: 2rem
  space-xl: 2.5rem
  space-2xl: 3rem
  space-3xl: 4rem
---

# Design System Specification
**Project:** Vehicle Workshop Management System  
**Version:** 1.0.0  
**Target Audience:** Customers, Service Advisors, Technicians, Supervisors, Admins  

## 1. System Context & Architecture
The system is divided into three decoupled sub-systems with distinct visual requirements:
1. **Customer Facing Portal:** Consumer-grade UI. High focus on booking flows, service history, and clean billing interfaces.
2. **Internal Operations (Shop-Floor):** High-density data views, mobile-optimized drag-and-drop Kanban boards for technicians, and fast-action intake forms for Service Advisors.
3. **Admin & Financial Engine:** Analytical dashboards with data visualization (ChartJS) and heavy data tables for inventory and reporting.

## 2. UX Philosophy & "WOW" Factors
* **Industrial Modern:** The UI must feel precise, clean, and highly functional. Maximize data density on staff-facing views.
* **Command-Driven Navigation:** Implement global search via `Cmd + K` (or `Ctrl + K`) to open a centered search overlay for quick license plate/customer lookups.
* **Perceived Performance:** Never use spinning loading wheels. Use pulsing skeleton loaders (`#E5E7EB`) matching the layout of the incoming data.
* **Contextual Feedback:** Every major system action (e.g., "Job Card Assigned", "Invoice Paid") triggers a bottom-right toast notification that auto-dismisses after 3 seconds.

## 3. Color System (Strict HEX Codes)
The UI relies on a high-contrast layout (dark sidebar against a light workspace) accented by a vibrant, energetic brand color.

### Brand Accents
* **Primary (Brand):** `#F97316` (Vibrant Orange - primary buttons, active states, progress indicators)
* **Primary Hover:** `#EA580C` (Darker Orange)
* **Primary Subtle:** `#FFF7ED` (Light orange - active row backgrounds)

### Layout & Surfaces
* **Sidebar / Dark Panels:** `#111827` (Deep Slate)
* **Sidebar Hover / Active:** `#1F2937`
* **Main Background (Canvas):** `#F9FAFB` (Off-white/Light Gray)
* **Card / Surface:** `#FFFFFF` (Pure White)
* **Borders / Dividers:** `#E5E7EB`

### Typography Colors
* **Text Primary (Headings):** `#111827`
* **Text Secondary (Labels/Subtitles):** `#6B7280`
* **Text Inverted (On Dark/Buttons):** `#FFFFFF`

### Semantic Status (Critical for Kanban & Inventory)
* **Success / QA Passed:** Text `#15803D`, BG `#DCFCE7`
* **Warning / Rework / Low Stock:** Text `#B45309`, BG `#FEF3C7`
* **Danger / Out of Stock:** Text `#B91C1C`, BG `#FEE2E2`
* **Info / In Progress:** Text `#1D4ED8`, BG `#DBEAFE`
* **Neutral / Pending:** Text `#374151`, BG `#F3F4F6`

## 4. Typography & Hierarchy
**Font Family:** `Inter` (Sans-serif, highly legible for dense numerical data).

* **H1 (Page Titles):** 24px | Semi-Bold | `#111827` | Tracking: -0.02em
* **H2 (Card Headers):** 18px | Medium | `#111827`
* **Body (Tables/Inputs):** 14px | Regular | `#111827`
* **Secondary (Timestamps/Badges):** 12px | Medium | `#6B7280`
* **Button Text:** 14px | Medium | Title Case (No all-caps)

## 5. Grid, Layout, & Shapes
* **Grid System:** Strict 8pt Grid (8, 16, 24, 32, 40, 48, 64).
* **Sidebar:** Fixed `256px` width on desktop.
* **Top Header:** Fixed `64px` height.
* **Content Container:** Fluid width with a max-width of `1440px`.
* **Border Radius:** `8px` (`0.5rem`) universally applied to Buttons, Cards, Inputs, and Modals.
* **Shadows (Cards):** `0 1px 3px 0 rgba(0,0,0,0.1), 0 1px 2px -1px rgba(0,0,0,0.1)` (Very subtle).
* **Shadows (Modals/Dropdowns):** `0 20px 25px -5px rgba(0,0,0,0.1)` (High elevation).

## 6. Component Specifications

### Buttons
* **Primary:** Solid `#F97316` background, `#FFFFFF` text. Used once per view.
* **Secondary:** Solid `#FFFFFF` background, `#D1D5DB` border, `#111827` text. Used for "Cancel".
* **Ghost (Row Actions):** Transparent background, `#6B7280` text, hovers to `#F3F4F6`.

### Inputs & Forms
* **Labels:** 14px, Medium, `#374151`, positioned directly above the input.
* **Input Field:** `40px` height, `#FFFFFF` BG, `#D1D5DB` border, `8px` radius.
* **Focus State (Crucial):** Explicit `2px` solid ring in `#F97316` with a `2px` offset.

### Data Tables
* **Headers:** 12px, Uppercase, Medium, `#6B7280`.
* **Rows:** `64px` height for comfortable touch targets.
* **Hover:** Row background shifts to `#F9FAFB` on hover.
* **Actions:** Use Ghost buttons or standard `...` dropdown menus to prevent visual clutter. Avoid repetitive solid primary buttons on every row.

### Kanban Cards (Technician Workspace)
* Cards must display: Vehicle License Plate, Service Type, assigned Technician Avatar, and a Semantic Status Badge.
* **Drag State:** When dragged, card rotates `2deg` and shadow increases to High Elevation.

### Authentication Screens
* Must use a **50/50 Split-Screen Layout**. The left 50% contains the white login/registration form. The right 50% contains a dark `#111827` brand panel with a subtle 10% opacity watermark or image.

## 7. Accessibility (A11y)
* Minimum touch target size is `44x44px` for all interactive elements on mobile-responsive views (especially the Technician Workspace).
* All interactive elements must possess explicit `:focus-visible` states.
