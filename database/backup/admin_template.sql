-- phpMyAdmin SQL Dump
-- version 5.0.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 20, 2021 at 10:53 AM
-- Server version: 10.4.14-MariaDB
-- PHP Version: 7.4.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `admin_template`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `name`, `email`, `username`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Rownak', 'dcrownak@gmail.com', 'dcrownak', '$2y$12$v7bn/EfkB8x4cUOvBmHtOuhiP4Csa3GfUPIfzmve0sRPPTbTs9zqC', 'dcfjIk7sJYunUUeezaj9MesKQnbCTuxAahz2LciKfca9UxLDk4z4oaojfzAJ', '2020-12-12 07:34:26', NULL),
(2, 'Admin', 'admin@admin.com', 'admin', '$2y$10$K9cwJlyVHZRowKWxOZ4.MOJtht1o7Mbc6Vi0HPp1TTIZsW2TotXga', NULL, '2020-12-17 04:27:00', '2020-12-17 03:54:32');

-- --------------------------------------------------------

--
-- Table structure for table `admin_profiles`
--

CREATE TABLE `admin_profiles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `admin_id` bigint(20) UNSIGNED DEFAULT NULL,
  `city` varchar(32) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `state` varchar(32) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(32) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `profile_picture` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_login_at` timestamp NULL DEFAULT NULL,
  `last_login_ip` varchar(16) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `admin_profiles`
--

INSERT INTO `admin_profiles` (`id`, `admin_id`, `city`, `state`, `phone`, `address`, `profile_picture`, `last_login_at`, `last_login_ip`, `created_at`, `updated_at`) VALUES
(1, 1, 'Dhaka', 'Dhaka', '01911105804', 'R - 08, H - 41, Nikunja - 02, Dhaka - 1229.', 'dcrownak.png', NULL, NULL, '2021-01-16 06:35:21', '2021-02-15 06:00:06'),
(2, 2, 'Dhaka', 'Dhaka', '01811105804', '', 'admin.png', NULL, NULL, '2021-02-02 03:58:55', '2021-02-02 03:59:44');

-- --------------------------------------------------------

--
-- Table structure for table `basic_controls`
--

CREATE TABLE `basic_controls` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `currency_layer_access_key` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `currency_layer_auto_update` tinyint(1) NOT NULL DEFAULT 0,
  `currency_layer_auto_update_at` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `coin_market_cap_app_key` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `coin_market_cap_auto_update` tinyint(1) NOT NULL DEFAULT 0,
  `coin_market_cap_auto_update_at` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `site_title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `yellow` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `primaryColor` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lightBlue` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `blueberry` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mobileApp` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gradient2` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pink` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `footerBaseColor` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `footerSecondaryColor` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `copyRightColor` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `time_zone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `base_currency` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `base_currency_code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `currency_symbol` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fraction_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `paginate` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sender_email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sender_email_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `push_notification` tinyint(1) NOT NULL DEFAULT 0,
  `email_notification` tinyint(1) NOT NULL DEFAULT 0,
  `email_verification` tinyint(1) NOT NULL DEFAULT 0,
  `sms_notification` tinyint(1) NOT NULL DEFAULT 0,
  `sms_verification` tinyint(1) NOT NULL DEFAULT 0,
  `allowUser` tinyint(1) NOT NULL DEFAULT 0,
  `joining_bonus` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deposit_commission` tinyint(1) NOT NULL DEFAULT 0,
  `login_commission` tinyint(1) NOT NULL DEFAULT 0,
  `transfer` tinyint(1) NOT NULL DEFAULT 0,
  `request` tinyint(1) NOT NULL DEFAULT 0,
  `exchange` tinyint(1) NOT NULL DEFAULT 0,
  `redeem` tinyint(1) NOT NULL DEFAULT 0,
  `escrow` tinyint(1) NOT NULL DEFAULT 0,
  `voucher` tinyint(1) NOT NULL DEFAULT 0,
  `deposit` tinyint(1) NOT NULL DEFAULT 0,
  `tawk_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tawk_status` tinyint(1) NOT NULL DEFAULT 0,
  `fb_messenger_status` tinyint(1) NOT NULL DEFAULT 0,
  `fb_app_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fb_page_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `reCaptcha_status_login` tinyint(1) NOT NULL DEFAULT 0,
  `reCaptcha_status_registration` tinyint(1) NOT NULL DEFAULT 0,
  `MEASUREMENT_ID` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `analytic_status` tinyint(1) NOT NULL,
  `social_description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `social_title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meta_description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meta_keywords` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `basic_controls`
--

INSERT INTO `basic_controls` (`id`, `currency_layer_access_key`, `currency_layer_auto_update`, `currency_layer_auto_update_at`, `coin_market_cap_app_key`, `coin_market_cap_auto_update`, `coin_market_cap_auto_update_at`, `site_title`, `yellow`, `primaryColor`, `lightBlue`, `blueberry`, `mobileApp`, `gradient2`, `pink`, `footerBaseColor`, `footerSecondaryColor`, `copyRightColor`, `time_zone`, `base_currency`, `base_currency_code`, `currency_symbol`, `fraction_number`, `paginate`, `sender_email`, `sender_email_name`, `email_description`, `push_notification`, `email_notification`, `email_verification`, `sms_notification`, `sms_verification`, `allowUser`, `joining_bonus`, `deposit_commission`, `login_commission`, `transfer`, `request`, `exchange`, `redeem`, `escrow`, `voucher`, `deposit`, `tawk_id`, `tawk_status`, `fb_messenger_status`, `fb_app_id`, `fb_page_id`, `reCaptcha_status_login`, `reCaptcha_status_registration`, `MEASUREMENT_ID`, `analytic_status`, `social_description`, `social_title`, `meta_description`, `meta_keywords`, `created_at`, `updated_at`) VALUES
(1, '36fbb3371745a95658426245035598db', 1, 'everyMinute', '726ffba5-8523-4071-92d4-1775dbc481c4', 1, 'everyMinute', 'Binary Operation', 'f2f506', '22d199', '47f1ff', '7450fe', 'd3f6eb', '6a50fe', 'ff6699', '5752f1', '5f5aff', '4e4ad6', '231', '1', 'USD', '$', '2', '20', 'support@mail.com', 'Binary Operation', '\"<meta http-equiv=\\\"Content-Type\\\" content=\\\"text\\/html; charset=utf-8\\\">\\r\\n<meta http-equiv=\\\"X-UA-Compatible\\\" content=\\\"IE=edge\\\">\\r\\n<meta name=\\\"viewport\\\" content=\\\"width=device-width\\\">\\r\\n<style type=\\\"text\\/css\\\">\\r\\n    @media only screen and (min-width: 620px) {\\r\\n        * [lang=x-wrapper] h1 {\\r\\n        }\\r\\n\\r\\n        * [lang=x-wrapper] h1 {\\r\\n            font-size: 26px !important;\\r\\n            line-height: 34px !important\\r\\n        }\\r\\n\\r\\n        * [lang=x-wrapper] h2 {\\r\\n        }\\r\\n\\r\\n        * [lang=x-wrapper] h2 {\\r\\n            font-size: 20px !important;\\r\\n            line-height: 28px !important\\r\\n        }\\r\\n\\r\\n        * [lang=x-wrapper] h3 {\\r\\n        }\\r\\n\\r\\n        * [lang=x-layout__inner] p,\\r\\n        * [lang=x-layout__inner] ol,\\r\\n        * [lang=x-layout__inner] ul {\\r\\n        }\\r\\n\\r\\n        * div [lang=x-size-8] {\\r\\n            font-size: 8px !important;\\r\\n            line-height: 14px !important\\r\\n        }\\r\\n\\r\\n        * div [lang=x-size-9] {\\r\\n            font-size: 9px !important;\\r\\n            line-height: 16px !important\\r\\n        }\\r\\n\\r\\n        * div [lang=x-size-10] {\\r\\n            font-size: 10px !important;\\r\\n            line-height: 18px !important\\r\\n        }\\r\\n\\r\\n        * div [lang=x-size-11] {\\r\\n            font-size: 11px !important;\\r\\n            line-height: 19px !important\\r\\n        }\\r\\n\\r\\n        * div [lang=x-size-12] {\\r\\n            font-size: 12px !important;\\r\\n            line-height: 19px !important\\r\\n        }\\r\\n\\r\\n        * div [lang=x-size-13] {\\r\\n            font-size: 13px !important;\\r\\n            line-height: 21px !important\\r\\n        }\\r\\n\\r\\n        * div [lang=x-size-14] {\\r\\n            font-size: 14px !important;\\r\\n            line-height: 21px !important\\r\\n        }\\r\\n\\r\\n        * div [lang=x-size-15] {\\r\\n            font-size: 15px !important;\\r\\n            line-height: 23px !important\\r\\n        }\\r\\n\\r\\n        * div [lang=x-size-16] {\\r\\n            font-size: 16px !important;\\r\\n            line-height: 24px !important\\r\\n        }\\r\\n\\r\\n        * div [lang=x-size-17] {\\r\\n            font-size: 17px !important;\\r\\n            line-height: 26px !important\\r\\n        }\\r\\n\\r\\n        * div [lang=x-size-18] {\\r\\n            font-size: 18px !important;\\r\\n            line-height: 26px !important\\r\\n        }\\r\\n\\r\\n        * div [lang=x-size-18] {\\r\\n            font-size: 18px !important;\\r\\n            line-height: 26px !important\\r\\n        }\\r\\n\\r\\n        * div [lang=x-size-20] {\\r\\n            font-size: 20px !important;\\r\\n            line-height: 28px !important\\r\\n        }\\r\\n\\r\\n        * div [lang=x-size-22] {\\r\\n            font-size: 22px !important;\\r\\n            line-height: 31px !important\\r\\n        }\\r\\n\\r\\n        * div [lang=x-size-24] {\\r\\n            font-size: 24px !important;\\r\\n            line-height: 32px !important\\r\\n        }\\r\\n\\r\\n        * div [lang=x-size-26] {\\r\\n            font-size: 26px !important;\\r\\n            line-height: 34px !important\\r\\n        }\\r\\n\\r\\n        * div [lang=x-size-28] {\\r\\n            font-size: 28px !important;\\r\\n            line-height: 36px !important\\r\\n        }\\r\\n\\r\\n        * div [lang=x-size-30] {\\r\\n            font-size: 30px !important;\\r\\n            line-height: 38px !important\\r\\n        }\\r\\n\\r\\n        * div [lang=x-size-32] {\\r\\n            font-size: 32px !important;\\r\\n            line-height: 40px !important\\r\\n        }\\r\\n\\r\\n        * div [lang=x-size-34] {\\r\\n            font-size: 34px !important;\\r\\n            line-height: 43px !important\\r\\n        }\\r\\n\\r\\n        * div [lang=x-size-36] {\\r\\n            font-size: 36px !important;\\r\\n            line-height: 43px !important\\r\\n        }\\r\\n\\r\\n        * div [lang=x-size-40] {\\r\\n            font-size: 40px !important;\\r\\n            line-height: 47px !important\\r\\n        }\\r\\n\\r\\n        * div [lang=x-size-44] {\\r\\n            font-size: 44px !important;\\r\\n            line-height: 50px !important\\r\\n        }\\r\\n\\r\\n        * div [lang=x-size-48] {\\r\\n            font-size: 48px !important;\\r\\n            line-height: 54px !important\\r\\n        }\\r\\n\\r\\n        * div [lang=x-size-56] {\\r\\n            font-size: 56px !important;\\r\\n            line-height: 60px !important\\r\\n        }\\r\\n\\r\\n        * div [lang=x-size-64] {\\r\\n            font-size: 64px !important;\\r\\n            line-height: 63px !important\\r\\n        }\\r\\n    }\\r\\n<\\/style>\\r\\n<style type=\\\"text\\/css\\\">\\r\\n    body {\\r\\n        margin: 0;\\r\\n        padding: 0;\\r\\n    }\\r\\n\\r\\n    table {\\r\\n        border-collapse: collapse;\\r\\n        table-layout: fixed;\\r\\n    }\\r\\n\\r\\n    * {\\r\\n        line-height: inherit;\\r\\n    }\\r\\n\\r\\n    [x-apple-data-detectors],\\r\\n    [href^=\\\"tel\\\"],\\r\\n    [href^=\\\"sms\\\"] {\\r\\n        color: inherit !important;\\r\\n        text-decoration: none !important;\\r\\n    }\\r\\n\\r\\n    .wrapper .footer__share-button a:hover,\\r\\n    .wrapper .footer__share-button a:focus {\\r\\n        color: #ffffff !important;\\r\\n    }\\r\\n\\r\\n    .btn a:hover,\\r\\n    .btn a:focus,\\r\\n    .footer__share-button a:hover,\\r\\n    .footer__share-button a:focus,\\r\\n    .email-footer__links a:hover,\\r\\n    .email-footer__links a:focus {\\r\\n        opacity: 0.8;\\r\\n    }\\r\\n\\r\\n    .preheader,\\r\\n    .header,\\r\\n    .layout,\\r\\n    .column {\\r\\n        transition: width 0.25s ease-in-out, max-width 0.25s ease-in-out;\\r\\n    }\\r\\n\\r\\n    .layout,\\r\\n    .header {\\r\\n        max-width: 400px !important;\\r\\n        -fallback-width: 95% !important;\\r\\n        width: calc(100% - 20px) !important;\\r\\n    }\\r\\n\\r\\n    div.preheader {\\r\\n        max-width: 360px !important;\\r\\n        -fallback-width: 90% !important;\\r\\n        width: calc(100% - 60px) !important;\\r\\n    }\\r\\n\\r\\n    .snippet,\\r\\n    .webversion {\\r\\n        Float: none !important;\\r\\n    }\\r\\n\\r\\n    .column {\\r\\n        max-width: 400px !important;\\r\\n        width: 100% !important;\\r\\n    }\\r\\n\\r\\n    .fixed-width.has-border {\\r\\n        max-width: 402px !important;\\r\\n    }\\r\\n\\r\\n    .fixed-width.has-border .layout__inner {\\r\\n        box-sizing: border-box;\\r\\n    }\\r\\n\\r\\n    .snippet,\\r\\n    .webversion {\\r\\n        width: 50% !important;\\r\\n    }\\r\\n\\r\\n    .ie .btn {\\r\\n        width: 100%;\\r\\n    }\\r\\n\\r\\n    .ie .column,\\r\\n    [owa] .column,\\r\\n    .ie .gutter,\\r\\n    [owa] .gutter {\\r\\n        display: table-cell;\\r\\n        float: none !important;\\r\\n        vertical-align: top;\\r\\n    }\\r\\n\\r\\n    .ie div.preheader,\\r\\n    [owa] div.preheader,\\r\\n    .ie .email-footer,\\r\\n    [owa] .email-footer {\\r\\n        max-width: 560px !important;\\r\\n        width: 560px !important;\\r\\n    }\\r\\n\\r\\n    .ie .snippet,\\r\\n    [owa] .snippet,\\r\\n    .ie .webversion,\\r\\n    [owa] .webversion {\\r\\n        width: 280px !important;\\r\\n    }\\r\\n\\r\\n    .ie .header,\\r\\n    [owa] .header,\\r\\n    .ie .layout,\\r\\n    [owa] .layout,\\r\\n    .ie .one-col .column,\\r\\n    [owa] .one-col .column {\\r\\n        max-width: 600px !important;\\r\\n        width: 600px !important;\\r\\n    }\\r\\n\\r\\n    .ie .fixed-width.has-border,\\r\\n    [owa] .fixed-width.has-border,\\r\\n    .ie .has-gutter.has-border,\\r\\n    [owa] .has-gutter.has-border {\\r\\n        max-width: 602px !important;\\r\\n        width: 602px !important;\\r\\n    }\\r\\n\\r\\n    .ie .two-col .column,\\r\\n    [owa] .two-col .column {\\r\\n        width: 300px !important;\\r\\n    }\\r\\n\\r\\n    .ie .three-col .column,\\r\\n    [owa] .three-col .column,\\r\\n    .ie .narrow,\\r\\n    [owa] .narrow {\\r\\n        width: 200px !important;\\r\\n    }\\r\\n\\r\\n    .ie .wide,\\r\\n    [owa] .wide {\\r\\n        width: 400px !important;\\r\\n    }\\r\\n\\r\\n    .ie .two-col.has-gutter .column,\\r\\n    [owa] .two-col.x_has-gutter .column {\\r\\n        width: 290px !important;\\r\\n    }\\r\\n\\r\\n    .ie .three-col.has-gutter .column,\\r\\n    [owa] .three-col.x_has-gutter .column,\\r\\n    .ie .has-gutter .narrow,\\r\\n    [owa] .has-gutter .narrow {\\r\\n        width: 188px !important;\\r\\n    }\\r\\n\\r\\n    .ie .has-gutter .wide,\\r\\n    [owa] .has-gutter .wide {\\r\\n        width: 394px !important;\\r\\n    }\\r\\n\\r\\n    .ie .two-col.has-gutter.has-border .column,\\r\\n    [owa] .two-col.x_has-gutter.x_has-border .column {\\r\\n        width: 292px !important;\\r\\n    }\\r\\n\\r\\n    .ie .three-col.has-gutter.has-border .column,\\r\\n    [owa] .three-col.x_has-gutter.x_has-border .column,\\r\\n    .ie .has-gutter.has-border .narrow,\\r\\n    [owa] .has-gutter.x_has-border .narrow {\\r\\n        width: 190px !important;\\r\\n    }\\r\\n\\r\\n    .ie .has-gutter.has-border .wide,\\r\\n    [owa] .has-gutter.x_has-border .wide {\\r\\n        width: 396px !important;\\r\\n    }\\r\\n\\r\\n    .ie .fixed-width .layout__inner {\\r\\n        border-left: 0 none white !important;\\r\\n        border-right: 0 none white !important;\\r\\n    }\\r\\n\\r\\n    .ie .layout__edges {\\r\\n        display: none;\\r\\n    }\\r\\n\\r\\n    .mso .layout__edges {\\r\\n        font-size: 0;\\r\\n    }\\r\\n\\r\\n    .layout-fixed-width,\\r\\n    .mso .layout-full-width {\\r\\n        background-color: #ffffff;\\r\\n    }\\r\\n\\r\\n    @media only screen and (min-width: 620px) {\\r\\n\\r\\n        .column,\\r\\n        .gutter {\\r\\n            display: table-cell;\\r\\n            Float: none !important;\\r\\n            vertical-align: top;\\r\\n        }\\r\\n\\r\\n        div.preheader,\\r\\n        .email-footer {\\r\\n            max-width: 560px !important;\\r\\n            width: 560px !important;\\r\\n        }\\r\\n\\r\\n        .snippet,\\r\\n        .webversion {\\r\\n            width: 280px !important;\\r\\n        }\\r\\n\\r\\n        .header,\\r\\n        .layout,\\r\\n        .one-col .column {\\r\\n            max-width: 600px !important;\\r\\n            width: 600px !important;\\r\\n        }\\r\\n\\r\\n        .fixed-width.has-border,\\r\\n        .fixed-width.ecxhas-border,\\r\\n        .has-gutter.has-border,\\r\\n        .has-gutter.ecxhas-border {\\r\\n            max-width: 602px !important;\\r\\n            width: 602px !important;\\r\\n        }\\r\\n\\r\\n        .two-col .column {\\r\\n            width: 300px !important;\\r\\n        }\\r\\n\\r\\n        .three-col .column,\\r\\n        .column.narrow {\\r\\n            width: 200px !important;\\r\\n        }\\r\\n\\r\\n        .column.wide {\\r\\n            width: 400px !important;\\r\\n        }\\r\\n\\r\\n        .two-col.has-gutter .column,\\r\\n        .two-col.ecxhas-gutter .column {\\r\\n            width: 290px !important;\\r\\n        }\\r\\n\\r\\n        .three-col.has-gutter .column,\\r\\n        .three-col.ecxhas-gutter .column,\\r\\n        .has-gutter .narrow {\\r\\n            width: 188px !important;\\r\\n        }\\r\\n\\r\\n        .has-gutter .wide {\\r\\n            width: 394px !important;\\r\\n        }\\r\\n\\r\\n        .two-col.has-gutter.has-border .column,\\r\\n        .two-col.ecxhas-gutter.ecxhas-border .column {\\r\\n            width: 292px !important;\\r\\n        }\\r\\n\\r\\n        .three-col.has-gutter.has-border .column,\\r\\n        .three-col.ecxhas-gutter.ecxhas-border .column,\\r\\n        .has-gutter.has-border .narrow,\\r\\n        .has-gutter.ecxhas-border .narrow {\\r\\n            width: 190px !important;\\r\\n        }\\r\\n\\r\\n        .has-gutter.has-border .wide,\\r\\n        .has-gutter.ecxhas-border .wide {\\r\\n            width: 396px !important;\\r\\n        }\\r\\n    }\\r\\n\\r\\n    @media only screen and (-webkit-min-device-pixel-ratio: 2), only screen and (min--moz-device-pixel-ratio: 2), only screen and (-o-min-device-pixel-ratio: 2\\/1), only screen and (min-device-pixel-ratio: 2), only screen and (min-resolution: 192dpi), only screen and (min-resolution: 2dppx) {\\r\\n        .fblike {\\r\\n            background-image: url(https:\\/\\/i3.createsend1.com\\/static\\/eb\\/customise\\/13-the-blueprint-3\\/images\\/fblike@2x.png) !important;\\r\\n        }\\r\\n\\r\\n        .tweet {\\r\\n            background-image: url(https:\\/\\/i4.createsend1.com\\/static\\/eb\\/customise\\/13-the-blueprint-3\\/images\\/tweet@2x.png) !important;\\r\\n        }\\r\\n\\r\\n        .linkedinshare {\\r\\n            background-image: url(https:\\/\\/i6.createsend1.com\\/static\\/eb\\/customise\\/13-the-blueprint-3\\/images\\/lishare@2x.png) !important;\\r\\n        }\\r\\n\\r\\n        .forwardtoafriend {\\r\\n            background-image: url(https:\\/\\/i5.createsend1.com\\/static\\/eb\\/customise\\/13-the-blueprint-3\\/images\\/forward@2x.png) !important;\\r\\n        }\\r\\n    }\\r\\n\\r\\n    @media (max-width: 321px) {\\r\\n        .fixed-width.has-border .layout__inner {\\r\\n            border-width: 1px 0 !important;\\r\\n        }\\r\\n\\r\\n        .layout,\\r\\n        .column {\\r\\n            min-width: 320px !important;\\r\\n            width: 320px !important;\\r\\n        }\\r\\n\\r\\n        .border {\\r\\n            display: none;\\r\\n        }\\r\\n    }\\r\\n\\r\\n    .mso div {\\r\\n        border: 0 none white !important;\\r\\n    }\\r\\n\\r\\n    .mso .w560 .divider {\\r\\n        margin-left: 260px !important;\\r\\n        margin-right: 260px !important;\\r\\n    }\\r\\n\\r\\n    .mso .w360 .divider {\\r\\n        margin-left: 160px !important;\\r\\n        margin-right: 160px !important;\\r\\n    }\\r\\n\\r\\n    .mso .w260 .divider {\\r\\n        margin-left: 110px !important;\\r\\n        margin-right: 110px !important;\\r\\n    }\\r\\n\\r\\n    .mso .w160 .divider {\\r\\n        margin-left: 60px !important;\\r\\n        margin-right: 60px !important;\\r\\n    }\\r\\n\\r\\n    .mso .w354 .divider {\\r\\n        margin-left: 157px !important;\\r\\n        margin-right: 157px !important;\\r\\n    }\\r\\n\\r\\n    .mso .w250 .divider {\\r\\n        margin-left: 105px !important;\\r\\n        margin-right: 105px !important;\\r\\n    }\\r\\n\\r\\n    .mso .w148 .divider {\\r\\n        margin-left: 54px !important;\\r\\n        margin-right: 54px !important;\\r\\n    }\\r\\n\\r\\n    .mso .font-avenir,\\r\\n    .mso .font-cabin,\\r\\n    .mso .font-open-sans,\\r\\n    .mso .font-ubuntu {\\r\\n        font-family: sans-serif !important;\\r\\n    }\\r\\n\\r\\n    .mso .font-bitter,\\r\\n    .mso .font-merriweather,\\r\\n    .mso .font-pt-serif {\\r\\n        font-family: Georgia, serif !important;\\r\\n    }\\r\\n\\r\\n    .mso .font-lato,\\r\\n    .mso .font-roboto {\\r\\n        font-family: Tahoma, sans-serif !important;\\r\\n    }\\r\\n\\r\\n    .mso .font-pt-sans {\\r\\n        font-family: \\\"Trebuchet MS\\\", sans-serif !important;\\r\\n    }\\r\\n\\r\\n    .mso .footer__share-button p {\\r\\n        margin: 0;\\r\\n    }\\r\\n\\r\\n    @media only screen and (min-width: 620px) {\\r\\n        .wrapper .size-8 {\\r\\n            font-size: 8px !important;\\r\\n            line-height: 14px !important;\\r\\n        }\\r\\n\\r\\n        .wrapper .size-9 {\\r\\n            font-size: 9px !important;\\r\\n            line-height: 16px !important;\\r\\n        }\\r\\n\\r\\n        .wrapper .size-10 {\\r\\n            font-size: 10px !important;\\r\\n            line-height: 18px !important;\\r\\n        }\\r\\n\\r\\n        .wrapper .size-11 {\\r\\n            font-size: 11px !important;\\r\\n            line-height: 19px !important;\\r\\n        }\\r\\n\\r\\n        .wrapper .size-12 {\\r\\n            font-size: 12px !important;\\r\\n            line-height: 19px !important;\\r\\n        }\\r\\n\\r\\n        .wrapper .size-13 {\\r\\n            font-size: 13px !important;\\r\\n            line-height: 21px !important;\\r\\n        }\\r\\n\\r\\n        .wrapper .size-14 {\\r\\n            font-size: 14px !important;\\r\\n            line-height: 21px !important;\\r\\n        }\\r\\n\\r\\n        .wrapper .size-15 {\\r\\n            font-size: 15px !important;\\r\\n            line-height: 23px !important;\\r\\n        }\\r\\n\\r\\n        .wrapper .size-16 {\\r\\n            font-size: 16px !important;\\r\\n            line-height: 24px !important;\\r\\n        }\\r\\n\\r\\n        .wrapper .size-17 {\\r\\n            font-size: 17px !important;\\r\\n            line-height: 26px !important;\\r\\n        }\\r\\n\\r\\n        .wrapper .size-18 {\\r\\n            font-size: 18px !important;\\r\\n            line-height: 26px !important;\\r\\n        }\\r\\n\\r\\n        .wrapper .size-20 {\\r\\n            font-size: 20px !important;\\r\\n            line-height: 28px !important;\\r\\n        }\\r\\n\\r\\n        .wrapper .size-22 {\\r\\n            font-size: 22px !important;\\r\\n            line-height: 31px !important;\\r\\n        }\\r\\n\\r\\n        .wrapper .size-24 {\\r\\n            font-size: 24px !important;\\r\\n            line-height: 32px !important;\\r\\n        }\\r\\n\\r\\n        .wrapper .size-26 {\\r\\n            font-size: 26px !important;\\r\\n            line-height: 34px !important;\\r\\n        }\\r\\n\\r\\n        .wrapper .size-28 {\\r\\n            font-size: 28px !important;\\r\\n            line-height: 36px !important;\\r\\n        }\\r\\n\\r\\n        .wrapper .size-30 {\\r\\n            font-size: 30px !important;\\r\\n            line-height: 38px !important;\\r\\n        }\\r\\n\\r\\n        .wrapper .size-32 {\\r\\n            font-size: 32px !important;\\r\\n            line-height: 40px !important;\\r\\n        }\\r\\n\\r\\n        .wrapper .size-34 {\\r\\n            font-size: 34px !important;\\r\\n            line-height: 43px !important;\\r\\n        }\\r\\n\\r\\n        .wrapper .size-36 {\\r\\n            font-size: 36px !important;\\r\\n            line-height: 43px !important;\\r\\n        }\\r\\n\\r\\n        .wrapper .size-40 {\\r\\n            font-size: 40px !important;\\r\\n            line-height: 47px !important;\\r\\n        }\\r\\n\\r\\n        .wrapper .size-44 {\\r\\n            font-size: 44px !important;\\r\\n            line-height: 50px !important;\\r\\n        }\\r\\n\\r\\n        .wrapper .size-48 {\\r\\n            font-size: 48px !important;\\r\\n            line-height: 54px !important;\\r\\n        }\\r\\n\\r\\n        .wrapper .size-56 {\\r\\n            font-size: 56px !important;\\r\\n            line-height: 60px !important;\\r\\n        }\\r\\n\\r\\n        .wrapper .size-64 {\\r\\n            font-size: 64px !important;\\r\\n            line-height: 63px !important;\\r\\n        }\\r\\n    }\\r\\n\\r\\n    .mso .size-8,\\r\\n    .ie .size-8 {\\r\\n        font-size: 8px !important;\\r\\n        line-height: 14px !important;\\r\\n    }\\r\\n\\r\\n    .mso .size-9,\\r\\n    .ie .size-9 {\\r\\n        font-size: 9px !important;\\r\\n        line-height: 16px !important;\\r\\n    }\\r\\n\\r\\n    .mso .size-10,\\r\\n    .ie .size-10 {\\r\\n        font-size: 10px !important;\\r\\n        line-height: 18px !important;\\r\\n    }\\r\\n\\r\\n    .mso .size-11,\\r\\n    .ie .size-11 {\\r\\n        font-size: 11px !important;\\r\\n        line-height: 19px !important;\\r\\n    }\\r\\n\\r\\n    .mso .size-12,\\r\\n    .ie .size-12 {\\r\\n        font-size: 12px !important;\\r\\n        line-height: 19px !important;\\r\\n    }\\r\\n\\r\\n    .mso .size-13,\\r\\n    .ie .size-13 {\\r\\n        font-size: 13px !important;\\r\\n        line-height: 21px !important;\\r\\n    }\\r\\n\\r\\n    .mso .size-14,\\r\\n    .ie .size-14 {\\r\\n        font-size: 14px !important;\\r\\n        line-height: 21px !important;\\r\\n    }\\r\\n\\r\\n    .mso .size-15,\\r\\n    .ie .size-15 {\\r\\n        font-size: 15px !important;\\r\\n        line-height: 23px !important;\\r\\n    }\\r\\n\\r\\n    .mso .size-16,\\r\\n    .ie .size-16 {\\r\\n        font-size: 16px !important;\\r\\n        line-height: 24px !important;\\r\\n    }\\r\\n\\r\\n    .mso .size-17,\\r\\n    .ie .size-17 {\\r\\n        font-size: 17px !important;\\r\\n        line-height: 26px !important;\\r\\n    }\\r\\n\\r\\n    .mso .size-18,\\r\\n    .ie .size-18 {\\r\\n        font-size: 18px !important;\\r\\n        line-height: 26px !important;\\r\\n    }\\r\\n\\r\\n    .mso .size-20,\\r\\n    .ie .size-20 {\\r\\n        font-size: 20px !important;\\r\\n        line-height: 28px !important;\\r\\n    }\\r\\n\\r\\n    .mso .size-22,\\r\\n    .ie .size-22 {\\r\\n        font-size: 22px !important;\\r\\n        line-height: 31px !important;\\r\\n    }\\r\\n\\r\\n    .mso .size-24,\\r\\n    .ie .size-24 {\\r\\n        font-size: 24px !important;\\r\\n        line-height: 32px !important;\\r\\n    }\\r\\n\\r\\n    .mso .size-26,\\r\\n    .ie .size-26 {\\r\\n        font-size: 26px !important;\\r\\n        line-height: 34px !important;\\r\\n    }\\r\\n\\r\\n    .mso .size-28,\\r\\n    .ie .size-28 {\\r\\n        font-size: 28px !important;\\r\\n        line-height: 36px !important;\\r\\n    }\\r\\n\\r\\n    .mso .size-30,\\r\\n    .ie .size-30 {\\r\\n        font-size: 30px !important;\\r\\n        line-height: 38px !important;\\r\\n    }\\r\\n\\r\\n    .mso .size-32,\\r\\n    .ie .size-32 {\\r\\n        font-size: 32px !important;\\r\\n        line-height: 40px !important;\\r\\n    }\\r\\n\\r\\n    .mso .size-34,\\r\\n    .ie .size-34 {\\r\\n        font-size: 34px !important;\\r\\n        line-height: 43px !important;\\r\\n    }\\r\\n\\r\\n    .mso .size-36,\\r\\n    .ie .size-36 {\\r\\n        font-size: 36px !important;\\r\\n        line-height: 43px !important;\\r\\n    }\\r\\n\\r\\n    .mso .size-40,\\r\\n    .ie .size-40 {\\r\\n        font-size: 40px !important;\\r\\n        line-height: 47px !important;\\r\\n    }\\r\\n\\r\\n    .mso .size-44,\\r\\n    .ie .size-44 {\\r\\n        font-size: 44px !important;\\r\\n        line-height: 50px !important;\\r\\n    }\\r\\n\\r\\n    .mso .size-48,\\r\\n    .ie .size-48 {\\r\\n        font-size: 48px !important;\\r\\n        line-height: 54px !important;\\r\\n    }\\r\\n\\r\\n    .mso .size-56,\\r\\n    .ie .size-56 {\\r\\n        font-size: 56px !important;\\r\\n        line-height: 60px !important;\\r\\n    }\\r\\n\\r\\n    .mso .size-64,\\r\\n    .ie .size-64 {\\r\\n        font-size: 64px !important;\\r\\n        line-height: 63px !important;\\r\\n    }\\r\\n\\r\\n    .footer__share-button p {\\r\\n        margin: 0;\\r\\n    }\\r\\n<\\/style>\\r\\n\\r\\n<title><\\/title>\\r\\n<!--[if !mso]><!-->\\r\\n<style type=\\\"text\\/css\\\">\\r\\n    @import url(https:\\/\\/fonts.googleapis.com\\/css?family=Bitter:400,700,400italic|Cabin:400,700,400italic,700italic|Open+Sans:400italic,700italic,700,400);\\r\\n<\\/style>\\r\\n<link href=\\\"https:\\/\\/fonts.googleapis.com\\/css?family=Bitter:400,700,400italic|Cabin:400,700,400italic,700italic|Open+Sans:400italic,700italic,700,400\\\" rel=\\\"stylesheet\\\" type=\\\"text\\/css\\\">\\r\\n<!--<![endif]-->\\r\\n<style type=\\\"text\\/css\\\">\\r\\n    body {\\r\\n        background-color: #f5f7fa\\r\\n    }\\r\\n\\r\\n    .mso h1 {\\r\\n    }\\r\\n\\r\\n    .mso h1 {\\r\\n        font-family: sans-serif !important\\r\\n    }\\r\\n\\r\\n    .mso h2 {\\r\\n    }\\r\\n\\r\\n    .mso h3 {\\r\\n    }\\r\\n\\r\\n    .mso .column,\\r\\n    .mso .column__background td {\\r\\n    }\\r\\n\\r\\n    .mso .column,\\r\\n    .mso .column__background td {\\r\\n        font-family: sans-serif !important\\r\\n    }\\r\\n\\r\\n    .mso .btn a {\\r\\n    }\\r\\n\\r\\n    .mso .btn a {\\r\\n        font-family: sans-serif !important\\r\\n    }\\r\\n\\r\\n    .mso .webversion,\\r\\n    .mso .snippet,\\r\\n    .mso .layout-email-footer td,\\r\\n    .mso .footer__share-button p {\\r\\n    }\\r\\n\\r\\n    .mso .webversion,\\r\\n    .mso .snippet,\\r\\n    .mso .layout-email-footer td,\\r\\n    .mso .footer__share-button p {\\r\\n        font-family: sans-serif !important\\r\\n    }\\r\\n\\r\\n    .mso .logo {\\r\\n    }\\r\\n\\r\\n    .mso .logo {\\r\\n        font-family: Tahoma, sans-serif !important\\r\\n    }\\r\\n\\r\\n    .logo a:hover,\\r\\n    .logo a:focus {\\r\\n        color: #859bb1 !important\\r\\n    }\\r\\n\\r\\n    .mso .layout-has-border {\\r\\n        border-top: 1px solid #b1c1d8;\\r\\n        border-bottom: 1px solid #b1c1d8\\r\\n    }\\r\\n\\r\\n    .mso .layout-has-bottom-border {\\r\\n        border-bottom: 1px solid #b1c1d8\\r\\n    }\\r\\n\\r\\n    .mso .border,\\r\\n    .ie .border {\\r\\n        background-color: #b1c1d8\\r\\n    }\\r\\n\\r\\n    @media only screen and (min-width: 620px) {\\r\\n        .wrapper h1 {\\r\\n        }\\r\\n\\r\\n        .wrapper h1 {\\r\\n            font-size: 26px !important;\\r\\n            line-height: 34px !important\\r\\n        }\\r\\n\\r\\n        .wrapper h2 {\\r\\n        }\\r\\n\\r\\n        .wrapper h2 {\\r\\n            font-size: 20px !important;\\r\\n            line-height: 28px !important\\r\\n        }\\r\\n\\r\\n        .wrapper h3 {\\r\\n        }\\r\\n\\r\\n        .column p,\\r\\n        .column ol,\\r\\n        .column ul {\\r\\n        }\\r\\n    }\\r\\n\\r\\n    .mso h1,\\r\\n    .ie h1 {\\r\\n    }\\r\\n\\r\\n    .mso h1,\\r\\n    .ie h1 {\\r\\n        font-size: 26px !important;\\r\\n        line-height: 34px !important\\r\\n    }\\r\\n\\r\\n    .mso h2,\\r\\n    .ie h2 {\\r\\n    }\\r\\n\\r\\n    .mso h2,\\r\\n    .ie h2 {\\r\\n        font-size: 20px !important;\\r\\n        line-height: 28px !important\\r\\n    }\\r\\n\\r\\n    .mso h3,\\r\\n    .ie h3 {\\r\\n    }\\r\\n\\r\\n    .mso .layout__inner p,\\r\\n    .ie .layout__inner p,\\r\\n    .mso .layout__inner ol,\\r\\n    .ie .layout__inner ol,\\r\\n    .mso .layout__inner ul,\\r\\n    .ie .layout__inner ul {\\r\\n    }\\r\\n<\\/style>\\r\\n<meta name=\\\"robots\\\" content=\\\"noindex,nofollow\\\">\\r\\n\\r\\n<meta property=\\\"og:title\\\" content=\\\"Just One More Step\\\">\\r\\n\\r\\n<link href=\\\"https:\\/\\/css.createsend1.com\\/css\\/social.min.css?h=0ED47CE120160920\\\" media=\\\"screen,projection\\\" rel=\\\"stylesheet\\\" type=\\\"text\\/css\\\">\\r\\n\\r\\n\\r\\n<div class=\\\"wrapper\\\" style=\\\"min-width: 320px;background-color: #f5f7fa;\\\" lang=\\\"x-wrapper\\\">\\r\\n    <div class=\\\"preheader\\\" style=\\\"margin: 0 auto;max-width: 560px;min-width: 280px; width: 280px;\\\">\\r\\n        <div style=\\\"border-collapse: collapse;display: table;width: 100%;\\\">\\r\\n            <div class=\\\"snippet\\\" style=\\\"display: table-cell;Float: left;font-size: 12px;line-height: 19px;max-width: 280px;min-width: 140px; width: 140px;padding: 10px 0 5px 0;color: #b9b9b9;\\\">\\r\\n            <\\/div>\\r\\n            <div class=\\\"webversion\\\" style=\\\"display: table-cell;Float: left;font-size: 12px;line-height: 19px;max-width: 280px;min-width: 139px; width: 139px;padding: 10px 0 5px 0;text-align: right;color: #b9b9b9;\\\">\\r\\n            <\\/div>\\r\\n        <\\/div>\\r\\n\\r\\n        <div class=\\\"layout one-col fixed-width\\\" style=\\\"margin: 0 auto;max-width: 600px;min-width: 320px; width: 320px;overflow-wrap: break-word;word-wrap: break-word;word-break: break-word;\\\">\\r\\n            <div class=\\\"layout__inner\\\" style=\\\"border-collapse: collapse;display: table;width: 100%;background-color: #c4e5dc;\\\" lang=\\\"x-layout__inner\\\">\\r\\n                <div class=\\\"column\\\" style=\\\"text-align: left;color: #60666d;font-size: 14px;line-height: 21px;max-width:600px;min-width:320px;\\\">\\r\\n                    <div style=\\\"margin-left: 20px;margin-right: 20px;margin-top: 24px;margin-bottom: 24px;\\\">\\r\\n                        <h1 style=\\\"margin-top: 0;margin-bottom: 0;font-style: normal;font-weight: normal;color: #44a8c7;font-size: 36px;line-height: 43px;font-family: bitter,georgia,serif;text-align: center;\\\">\\r\\n                            <img src=\\\"data:image\\/png;base64,iVBORw0KGgoAAAANSUhEUgAAAHgAAAAtCAYAAABlJ6+WAAAMQ0lEQVR4nO1cC5AcRRn+EiCgKFxAESJCm6igE6kgLxEGCSQCVgRRQB7G9ElBtAo8AmIOFYYhYHhoXQWlhEBIA4oFoTgEqnwkeMoiCCQiWItYQGgVFCTCGVAIr1j\\/zN+z\\/3bP7u3tJVWmar6qzfX0e\\/rv\\/9k9QYUKFTZhjOt26lGc7gJgu3ot+UORaawFsCuA9QCGAfwFwJ8A3AvgV9Dq0aCjChsVm3dB2P0BDADYD8AiAGcElfKNM5F\\/0wCcwBuACLwUwDXQajhoVWGDY3wXHe7Hv27wEQCXAbAw9jwY+7aKpBsXIxPY2H1g7K5B\\/sjYlbn3VAA\\/BrBWtNgWQAqgDmMP2QTWaZNFewIb+yUANRa1o8VaaPUwtLoaWn0RwA4AqL9HRD\\/vB7AcxiYwtmt7oEJrtCYwLTpwHYAtg7JuoNU6aHUDgD3pCcAa7oXmcD6Aa2HsqG2CCu1RTmBjv8mLPhbcAGMvgrGHwdgtin60egta0caZmnFvAzozwCpO3qAICZyL5YuC\\/NFjFgDaKD8H8ByMvQzG7lT0otVzAI4AsFj0TKL84v\\/nBdvU0ExgYz8K4MqN8A6kw78O4HEYeyaMzcfV6k0AXwHwA1H3GzD2M0EPFbpCQ+cZuxn9C2AsrsuBALZiK5kMqI8DOArAB7h8awDfAzATxh4Prf4NrdbDWPKlKXByJNdbAmN3g1YvBiN4iOJ0bZDZAAVehshvr9cS63KjOJ3HVjzqtWQbL48CN0fWa0ngp4uxknotGQhGy+tQbKCXH2ncJKjkzaEENPZDAG6r15KlXL8HwN0AFFffQ75Ti34HJAcTJ32M068A+Gc47gjQ6mlo9QS0WgWtboFWxLUfYlH8sGh8OIBfwthts6eck+cAeJrL3w1gYfvBOoLixb47itNpHbaZ1mbh24KJ0Cvq9HLeaEFtplMgKYpTmnsPb7g+0c8iv88oTpWYu20QOA84fFvUpV33j+7W1ANxqFakh\\/cGcKEo3BfAYGE555Gtr4ryk2HsLkF\\/rbGUpYX8Oe6hBZvXsmUIIkxvkNtBO++Zxj06qBXCn\\/ecbG1yTHP91mvJkMifHsWp37ckeh9tCieiqcMdOf1XrnhSMI0REMWpC1sSsSgsubJeS97KcrR6A8C5MPZJJgZ4l55bEEKrO2HsCgAzWH2cDeD09qMWsLwAEkO8q3t5oecErVojjeL0oaZY+8hwBB4SYdp54n1LUTJvwiBz\\/3Tu16mEPs7r4TkOESGZ2NO5zoDr04loufO+C61eC4brDAP8oxe6nzZLFKenRXHa0PVakZ7\\/lujtHBj7QfEsreiTYOxY\\/fBAT3WAYV7AyzsVsczxTj\\/eJoiqSjitU\\/za9eHqe6JaCTXguNeKzYDxMHYyi0vCqwCu73IyZXgvgO\\/TRKM4fZcoJ\\/16D6fJRz6vKNHqLgBP8BNxwWEl\\/XYEwb1gruoUbgFHo48\\/y3+H2TAa5I0C9vG7gSNsk8FXryWD4n3mMXHdRuyTBiJxsIwF\\/yKzbLsHLcaCLCrVMJgIBwC4M4rTnBtJLwNnivIvwNjtxfNNIn1oh7MhcbVW\\/jgsqniBSq3ZMvACOi4YUR+zAVeIRzQ4rVBFvNk6BlvDbtzBknZ9QtI4CTHgi3sSnQeJ57uCbkaBei0pol9RnE5g33cBb6T9+DkPomj1IIz9LRN\\/C57kNWIeTowf1P2MCgQuz0gg9yaK0+mOi0kft2kiN4AkxlJh3M3zrOACI7h6w2U6nFykKE4HhIQZlqLZgRb+w+L5waD7LlGvJa\\/Va8l3mKgOZ0dxKv3sW0T6kyK9UqR36zB82cqKHmYuvr0Ll+VrUh8HpaEaGJS+KacdRx3dxfiD7JOXGnqeLz5Q5rtvzgEJh8eDXsaORXxkuDsHQD4F4Kfc672i96lFSquXYOyzbNnThpgE4JkRZtLKih7iAIETZQE3tAItbBSnCb9DKz9aGlBHtzGoejxrWOIoUcfp02EOqHRjJBYYL5QzLey\\/ghpjBLtJt4pe9hDp1SL9Pm+k50T6nWOYhVygUQcd2GBqtylG5V8HOewm8W\\/Q892v7zJQUoA4eDN+8I0r6SpJEbnOa98J\\/i7qSGNquE1fcpytOhhDsc6UmOZxWKmo6wAJH3M2cTEbX44ASZv+nTWeuUxMyFLQhmKiptxu0Sj99ybQor7JRN7WK5Nx4O1EWka4Oo00TRLpNSItd+cbXhvp\\/3bil\\/e24hDG0hIR3hE4kED6+HZvzm482yo2jXwjPMSc3sMuU0sCg3WrDNBEcUquV6mBNhLGN3FRs6vyvEhLPS1vZBwSxWnb2x5RnNIYnxdZfxTpySL9N6\\/pDiLdreqwvJh93S6QAxs6BRGFhY0RRLhzmWSIsZU+l236RJtuQ6cYB2MfALAPP38CWt2XpYw9K4tq5bgWWp3sGkVx+nsWWYTr6rWkpSMfxansh9TATvVa8gqPcYZYtB9Bq9mcT6dOL3P+f6HV1kHHFToCcddjoqK8LVkT6aNg7ATxLIMGc6I4vSaK0yYRT35wFKd04H+pyL6sIG6OY0T6NyK9l0jLU6gKo8R4diEcDhZp8omf4jSJ7hNdQb2W3OGFNIm7yfG+MYrThVGcLmEL+SIR7\\/6d4OT8tmYe5CC87lnaM0RabrQKXRBYRq+OEGe0FE68SpQtgLHSXTklE6sN9PAF934AX+Y4tCTSrHotWcfEHef5gzdBqxfEs+Ts24NZV+gYm0Orp2Ds\\/SyeJ7CV504mruAvFyjgsDMTPONkilQBmB3F6SCb9FNLBn2GDxauqtcSaSWf43HvBUWJsQeK6BpJkPuCXiWMPZXn5XzqmdBqNfdFRtyTovYyaHWcGOtmAMeK8rnQanFJ2Wpu2++NvZ7HW8HPZHC6jbqKVU3eZz6Xi73xae7zhbHZGL8xBxp3mXjuF+93FQeR3Hgz\\/VswTnwuEXlnFUd0Wr3sxU9PgLFNl+LqteTWei2hu1wRnyG7IDltmF3qteSKJuIa2+td6lsIrWQE7RyRvjq7hdkKxu6VEUGrcdBqCl8qWO7VXsHl4zLXz1hJUCLIlKJcLm5z2ZRsnJyAkjjLmEDg9XqRx5mSjVXep2vv5j5FzO9Yzpf1bxZ5sv3EbGM02h5Xdn\\/dBRduYC7akSNKZxZXZrSiAQ4VO2U+f+lwCm+ADPVa8igf8pcjv7lxvncWPMSHEW7SNM6n+Yks7h+W9tUAzemSpgU2Nn\\/5Du5zjRHzM+IYuzLjTsdVnaN57jku4fy5Im9uRuR80zSQv+tEGLs828Q5pwdzcLcbX21aaDqfNVYeQtCtijvE8\\/EA\\/pxdsZV3nstA+tbYw\\/kAQRL3gSzKlN\\/0oHrvyDi2gQs20AdqMzJRmt8kmVyIuwae5PL1HneDy1Zy22XFpjF2hlAJi5u4eMNjRUZkmocPrfZmmwfM6TP8KjI8eCUbR3txaJAaHACt1mY3PIw9hm9Ensb1J\\/GXDwv4OyR68Z1HuFXp8LNM3Luz59zoWiICKg+3Or3xsLhpdzsR2sy9JKJnBi0bmFK28xmOa5Z797dzvZnrYIe5Qev2WMy3V1Z4\\/fYHrUjHG7us6bZLrtNnsApYBWNXs80g+xP3onNdNycLLOSYmlm3zv8lImt1OnciT3bkS97DJ1IrWT+d5RH3Zc6b5V0sWMg6BHyr5MSCs9uBbm+SWGtw6PLM0GhGO1H9osfBF3tlYOLP5G+oJvPCTvZ0Zz+M9bm4bNxGXj73ZWLs9SwlVrWof0kT8fJ5kXR6gd99fonIL\\/kA3NjZno9LnX4uO8Jr1Hk7n5Well2v0epgzrcFN4cvtiSTAFo9K\\/oZx1JBnsgQcX8S9FChK4QEzhe+37uX\\/GgWT9bqMa\\/eFtk3v\\/QVYUjgO\\/h05e4sSqXV617b7fmi\\/SyR2887tcIGQjmBy4m8ji3tAWj1SlA\\/JPDEUiMp59rjOdDxHlFCVumlQf0KY0L48ZmDVqSPSFz\\/h3O2ZP+VrOd5MHZ0B9HkWxtLQRI6qLhREPfV7LvhirgbBa052MHY3dla3tcreS37\\/CQ3bB7gq64rSznY2En8n7Fs4\\/VRZ537CCpsFLTmYIdc7+7P3y7JM9sJrD8XcTjx+RYGloMk7kv8aemeFXE3Lkb3sXXuMs3mUOQBQXkzJAdvw5GpNRyduhxarQlaVNjg6P5r+vzDsEP4uuvu7O\\/2iOBJs5Fl7Cy+WP960FeFChUqVPAB4H\\/gGlO9+rYuJQAAAABJRU5ErkJggg==\\\" data-filename=\\\"5fceff4838f58.png\\\" style=\\\"width: 120px;\\\">\\r\\n                        <\\/h1>\\r\\n                    <\\/div>\\r\\n                <\\/div>\\r\\n            <\\/div>\\r\\n\\r\\n            <div class=\\\"layout one-col fixed-width\\\" style=\\\"margin: 0 auto;max-width: 600px;min-width: 320px;overflow-wrap: break-word;word-wrap: break-word;word-break: break-word;\\\">\\r\\n                <div class=\\\"layout__inner\\\" style=\\\"border-collapse: collapse;display: table;width: 100%;background-color: #ffffff;\\\" lang=\\\"x-layout__inner\\\">\\r\\n                    <div class=\\\"column\\\" style=\\\"text-align: left;color: #60666d;background: #edf1eb;font-size: 14px;line-height: 21px;max-width:600px;min-width:320px;width:320px;\\\">\\r\\n\\r\\n                        <div style=\\\"margin-left: 20px;margin-right: 20px;margin-top: 24px;\\\">\\r\\n                            <div style=\\\"line-height:10px;font-size:1px\\\">\\u00a0<\\/div>\\r\\n                        <\\/div>\\r\\n\\r\\n                        <div style=\\\"margin-left: 20px;margin-right: 20px;\\\">\\r\\n\\r\\n                            <p style=\\\"margin-top: 16px;margin-bottom: 0;\\\"><strong>Hello [[name]],<\\/strong><\\/p>\\r\\n                            <p style=\\\"margin-top: 20px;margin-bottom: 20px;\\\"><strong>[[message]]<\\/strong><\\/p>\\r\\n                            <p style=\\\"margin-top: 20px;margin-bottom: 20px;\\\"><strong>Sincerely,<br>Team Coder<\\/strong>\\r\\n                            <\\/p>\\r\\n                        <\\/div>\\r\\n\\r\\n                    <\\/div>\\r\\n                <\\/div>\\r\\n            <\\/div>\\r\\n\\r\\n            <div class=\\\"layout__inner\\\" style=\\\"border-collapse: collapse;display: table;width: 100%;background-color: #2c3262; margin-bottom: 20px\\\" lang=\\\"x-layout__inner\\\">\\r\\n                <div class=\\\"column\\\" style=\\\"text-align: left;color: #60666d;font-size: 14px;line-height: 21px;max-width:600px;min-width:320px;\\\">\\r\\n                    <div style=\\\"margin-top: 5px;margin-bottom: 5px;\\\">\\r\\n                        <p style=\\\"margin-top: 0;margin-bottom: 0;font-style: normal;font-weight: normal;color: #ffffff;font-size: 16px;line-height: 35px;font-family: bitter,georgia,serif;text-align: center;\\\">\\r\\n                            2021 \\u00a9  All Right Reserved\\r\\n                        <\\/p>\\r\\n                    <\\/div>\\r\\n                <\\/div>\\r\\n            <\\/div>\\r\\n\\r\\n        <\\/div>\\r\\n\\r\\n\\r\\n        <div style=\\\"border-collapse: collapse;display: table;width: 100%;\\\">\\r\\n            <div class=\\\"snippet\\\" style=\\\"display: table-cell;Float: left;font-size: 12px;line-height: 19px;max-width: 280px;min-width: 140px; width: 140px;padding: 10px 0 5px 0;color: #b9b9b9;\\\">\\r\\n            <\\/div>\\r\\n            <div class=\\\"webversion\\\" style=\\\"display: table-cell;Float: left;font-size: 12px;line-height: 19px;max-width: 280px;min-width: 139px; width: 139px;padding: 10px 0 5px 0;text-align: right;color: #b9b9b9;\\\">\\r\\n            <\\/div>\\r\\n        <\\/div>\\r\\n    <\\/div>\\r\\n<\\/div>\"', 1, 1, 1, 1, 1, 1, '25', 1, 1, 1, 1, 1, 1, 1, 1, 1, '5a929d64d7591465c707fe43', 0, 0, '1983831301869331', '1983831301869331', 0, 0, 'G-TFQZ8YZ468', 0, 'social_description', 'social_title', 'meta_description', 'meta_keywords', '2021-03-15 00:26:24', '2021-03-20 00:42:14');

-- --------------------------------------------------------

--
-- Table structure for table `charges_limits`
--

CREATE TABLE `charges_limits` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `currency_id` bigint(20) UNSIGNED DEFAULT NULL,
  `transaction_type_id` bigint(20) UNSIGNED DEFAULT NULL,
  `payment_method_id` bigint(20) UNSIGNED DEFAULT NULL,
  `percentage_charge` decimal(16,4) NOT NULL DEFAULT 0.0000,
  `fixed_charge` decimal(16,4) NOT NULL DEFAULT 0.0000,
  `min_limit` decimal(16,4) NOT NULL DEFAULT 0.0000,
  `max_limit` decimal(16,4) NOT NULL DEFAULT 0.0000,
  `is_active` tinyint(4) NOT NULL DEFAULT 1 COMMENT '1 = active, 0 = inactive',
  `convention_rate` decimal(16,8) DEFAULT 1.00000000,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `charges_limits`
--

INSERT INTO `charges_limits` (`id`, `currency_id`, `transaction_type_id`, `payment_method_id`, `percentage_charge`, `fixed_charge`, `min_limit`, `max_limit`, `is_active`, `convention_rate`, `created_at`, `updated_at`) VALUES
(1, 1, 1, NULL, '1.5000', '1.0000', '1.0000', '500.0000', 1, NULL, '2020-11-12 03:14:08', '2020-11-29 00:11:05'),
(2, 1, 2, NULL, '1.9000', '1.5000', '10.0000', '500.0000', 1, NULL, '2020-11-12 03:14:08', '2020-11-29 00:11:08'),
(3, 1, 3, NULL, '2.0000', '1.0000', '1.0000', '100.0000', 1, NULL, '2020-11-12 03:14:08', '2020-11-17 23:40:53'),
(4, 2, 1, NULL, '1.9000', '0.6000', '1.0000', '50.0000', 1, NULL, '2020-11-12 03:14:55', '2020-11-29 00:11:11'),
(5, 2, 2, NULL, '0.0000', '0.0000', '0.0000', '0.0000', 1, NULL, '2020-11-12 03:14:55', '2020-11-12 03:14:55'),
(6, 2, 3, NULL, '1.5000', '1.0000', '1.0000', '500.0000', 1, NULL, '2020-11-12 03:14:55', '2020-11-17 23:41:19'),
(7, 3, 1, NULL, '1.0000', '1.0000', '1.0000', '100.0000', 1, NULL, '2020-11-18 02:15:42', '2020-11-18 02:17:15'),
(8, 3, 2, NULL, '1.0000', '1.0000', '1.0000', '100.0000', 1, NULL, '2020-11-18 02:15:42', '2020-11-21 06:27:25'),
(9, 3, 3, NULL, '1.0000', '1.0000', '1.0000', '100.0000', 1, NULL, '2020-11-18 02:15:42', '2020-11-21 06:27:05'),
(10, 1, 4, NULL, '0.5000', '0.6000', '1.0000', '100.0000', 1, NULL, '2020-12-03 04:11:44', '2020-12-03 04:12:05'),
(11, 1, 5, NULL, '0.6000', '0.5000', '1.0000', '555.0000', 1, NULL, '2020-12-06 06:28:27', '2020-12-06 06:28:56'),
(12, 3, 5, NULL, '0.5000', '1.0000', '1.0000', '5000.0000', 1, NULL, '2020-12-06 06:32:20', '2020-12-06 06:32:31'),
(13, 1, 6, NULL, '0.5000', '1.0000', '1.0000', '500.0000', 1, NULL, '2020-12-10 03:58:29', '2020-12-10 03:58:41'),
(14, 2, 6, NULL, '0.5000', '1.0000', '1.0000', '5000.0000', 1, NULL, '2020-12-10 03:58:48', '2020-12-10 03:58:58'),
(15, 3, 6, NULL, '0.5000', '0.6000', '1.0000', '100.0000', 1, NULL, '2020-12-10 03:59:14', '2020-12-10 03:59:25'),
(16, 1, 7, NULL, '0.0000', '0.0000', '0.0000', '0.0000', 1, NULL, '2021-01-07 00:28:53', '2021-01-07 00:28:53'),
(17, 2, 7, NULL, '0.0000', '0.0000', '0.0000', '0.0000', 1, NULL, '2021-01-07 00:28:57', '2021-01-07 00:28:57'),
(18, 3, 7, NULL, '0.0000', '0.0000', '0.0000', '0.0000', 1, NULL, '2021-01-07 00:29:01', '2021-01-07 00:29:01'),
(22, 1, 7, 1, '0.8000', '1.0000', '1.0000', '600.0000', 1, '5.00000000', '2021-01-07 03:54:46', '2021-01-10 04:51:03'),
(23, 1, 7, 2, '1.0000', '2.0000', '1.0000', '500.0000', 1, '1.00000000', '2021-01-07 03:55:05', '2021-01-09 00:15:53'),
(24, 1, 7, 4, '2.0000', '1.5000', '2.0000', '60.0000', 1, '1.00000000', '2021-01-07 03:55:07', '2021-01-09 00:16:14'),
(25, 1, 7, 6, '0.9000', '0.5000', '2.0000', '90.0000', 1, '1.00000000', '2021-01-07 03:55:09', '2021-01-09 00:21:25'),
(26, 1, 7, 3, '0.6000', '0.8000', '1.0000', '500.0000', 1, '1.00000000', '2021-01-07 03:55:18', '2021-01-09 00:13:49'),
(27, 1, 7, 9, '1.0000', '1.5400', '1.0000', '250.0000', 1, '1.00000000', '2021-01-07 04:05:21', '2021-01-11 01:56:22'),
(28, 1, 7, 23, '1.0000', '2.0000', '1.0000', '258.0000', 1, '1.00000000', '2021-01-07 04:07:48', '2021-01-11 04:44:57'),
(29, 1, 7, 5, '1.0000', '1.0000', '1.0000', '150.0000', 1, '1.00000000', '2021-01-07 04:30:09', '2021-01-11 01:11:22'),
(30, 1, 7, 7, '1.0000', '2.0000', '1.0000', '250.0000', 1, '1.00000000', '2021-01-07 04:30:13', '2021-01-11 01:28:04'),
(31, 1, 7, 8, '1.0000', '2.0000', '1.0000', '250.0000', 1, '1.00000000', '2021-01-07 04:30:21', '2021-01-11 01:55:12'),
(32, 1, 7, 10, '1.0000', '1.5000', '1.0000', '650.0000', 1, '73.00000000', '2021-01-07 04:33:31', '2021-01-11 02:28:47'),
(33, 1, 7, 12, '1.5000', '2.0000', '1.0000', '520.0000', 1, '1.00000000', '2021-01-07 04:33:35', '2021-01-11 02:44:45'),
(34, 1, 7, 21, '1.0000', '2.0000', '1.0000', '1500.0000', 1, '1.00000000', '2021-01-07 04:33:38', '2021-01-11 04:35:23'),
(35, 1, 7, 19, '1.0000', '2.0000', '1.0000', '100.0000', 1, '1.00000000', '2021-01-07 04:33:39', '2021-01-11 04:35:13'),
(36, 1, 7, 18, '1.2000', '1.6000', '1.0000', '147.0000', 1, '1.00000000', '2021-01-07 04:33:39', '2021-01-11 04:34:46'),
(37, 1, 7, 22, '1.0000', '2.0000', '1.0000', '369.0000', 1, '1.00000000', '2021-01-07 04:33:40', '2021-01-11 04:30:42'),
(38, 1, 7, 20, '0.5000', '1.6000', '1.0000', '258.0000', 1, '381.25000000', '2021-01-07 04:33:41', '2021-01-11 04:19:37'),
(39, 1, 7, 17, '1.0000', '2.0000', '1.0000', '258.0000', 1, '25.00000000', '2021-01-07 04:33:41', '2021-01-11 04:04:49'),
(40, 1, 7, 16, '1.0000', '1.0000', '1.0000', '15.0000', 1, '73.00000000', '2021-01-07 04:33:42', '2021-01-10 23:51:31'),
(41, 1, 7, 15, '1.0000', '2.0000', '1.0000', '150.0000', 1, '1.00000000', '2021-01-07 04:33:42', '2021-01-10 23:51:08'),
(42, 1, 7, 14, '0.5000', '0.9000', '1.0000', '650.0000', 1, '1.00000000', '2021-01-07 04:33:44', '2021-01-10 23:50:52'),
(43, 1, 7, 13, '1.0000', '2.0000', '1.0000', '520.0000', 1, '1.00000000', '2021-01-07 04:33:44', '2021-01-11 03:07:31'),
(44, 1, 7, 11, '1.0000', '2.5000', '1.0000', '250.0000', 1, '73.00000000', '2021-01-07 04:33:45', '2021-01-11 02:37:48'),
(45, 2, 7, 3, '2.0000', '1.0000', '1.0000', '500.0000', 1, '25.00000000', '2021-01-07 04:51:15', '2021-01-07 07:05:35'),
(46, 2, 7, 1, '0.0000', '0.0000', '0.0000', '0.0000', 1, '0.00000000', '2021-01-07 04:51:28', '2021-01-07 07:05:38'),
(47, 2, 7, 2, '0.0000', '0.0000', '0.0000', '0.0000', 1, '15.00000000', '2021-01-07 04:51:31', '2021-01-07 06:53:42'),
(48, 2, 7, 4, '0.0000', '0.0000', '0.0000', '0.0000', 1, '0.00000000', '2021-01-07 04:51:32', '2021-01-07 04:51:32'),
(49, 2, 7, 6, '0.0000', '0.0000', '0.0000', '0.0000', 1, '0.00000000', '2021-01-07 04:51:33', '2021-01-07 04:51:33'),
(50, 2, 7, 5, '0.0000', '0.0000', '0.0000', '0.0000', 1, '0.00000000', '2021-01-07 04:51:44', '2021-01-07 04:51:44'),
(51, 2, 7, 7, '0.0000', '0.0000', '0.0000', '0.0000', 1, '0.00000000', '2021-01-07 04:51:45', '2021-01-07 04:51:45'),
(52, 2, 7, 8, '0.0000', '0.0000', '0.0000', '0.0000', 1, '0.00000000', '2021-01-07 04:51:46', '2021-01-07 04:51:46'),
(53, 2, 7, 9, '0.0000', '0.0000', '0.0000', '0.0000', 1, '0.00000000', '2021-01-07 04:51:46', '2021-01-07 04:51:46'),
(54, 2, 7, 10, '0.0000', '0.0000', '0.0000', '0.0000', 1, '0.00000000', '2021-01-07 04:51:47', '2021-01-07 04:51:47'),
(55, 2, 7, 11, '0.0000', '0.0000', '0.0000', '0.0000', 1, '0.00000000', '2021-01-07 04:51:47', '2021-01-07 04:51:47'),
(56, 2, 7, 18, '0.0000', '0.0000', '0.0000', '0.0000', 1, '0.00000000', '2021-01-07 04:51:53', '2021-01-07 04:51:53'),
(57, 2, 7, 21, '0.0000', '0.0000', '0.0000', '0.0000', 1, '0.00000000', '2021-01-07 04:51:54', '2021-01-07 04:51:54'),
(58, 2, 7, 12, '0.0000', '0.0000', '0.0000', '0.0000', 1, '0.00000000', '2021-01-07 07:00:33', '2021-01-07 07:00:33'),
(59, 2, 7, 13, '0.0000', '0.0000', '0.0000', '0.0000', 1, '0.00000000', '2021-01-07 07:00:46', '2021-01-07 07:00:46'),
(60, 2, 7, 14, '0.0000', '0.0000', '0.0000', '0.0000', 1, '0.00000000', '2021-01-07 07:00:50', '2021-01-07 07:00:50'),
(61, 3, 7, 3, '0.0000', '0.0000', '0.0000', '0.0000', 1, '0.00000000', '2021-01-09 01:00:29', '2021-01-09 01:00:29'),
(62, 3, 7, 1, '0.0000', '0.0000', '0.0000', '0.0000', 1, '0.00000000', '2021-01-09 01:00:43', '2021-01-09 01:00:43'),
(63, 3, 7, 4, '0.0000', '0.0000', '0.0000', '0.0000', 1, '0.00000000', '2021-01-09 01:00:50', '2021-01-09 01:00:50'),
(64, 1, 7, 25, '0.5000', '0.6000', '1.0000', '150.0000', 1, '160.00000000', '2021-01-14 02:20:43', '2021-01-14 02:22:15'),
(65, 4, 1, NULL, '0.0000', '0.0000', '0.0000', '0.0000', 1, '1.00000000', '2021-01-20 01:49:09', '2021-01-20 01:49:09'),
(66, 4, 2, NULL, '0.0000', '0.0000', '0.0000', '0.0000', 1, '1.00000000', '2021-01-20 01:49:09', '2021-01-20 01:49:09'),
(67, 4, 3, NULL, '0.0000', '0.0000', '0.0000', '0.0000', 1, '1.00000000', '2021-01-20 01:49:09', '2021-01-20 01:49:09'),
(68, 3, 7, 25, '0.0000', '0.0000', '0.0000', '0.0000', 1, '1.00000000', '2021-02-11 03:51:02', '2021-02-11 03:51:02');

-- --------------------------------------------------------

--
-- Table structure for table `commission_entries`
--

CREATE TABLE `commission_entries` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `to_user` bigint(20) UNSIGNED DEFAULT NULL,
  `currency_id` bigint(20) DEFAULT NULL,
  `from_user` bigint(20) UNSIGNED DEFAULT NULL,
  `level` int(11) DEFAULT NULL,
  `commission_amount` decimal(18,8) NOT NULL DEFAULT 0.00000000,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `utr` char(36) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `commission_entries`
--

INSERT INTO `commission_entries` (`id`, `to_user`, `currency_id`, `from_user`, `level`, `commission_amount`, `title`, `type`, `utr`, `created_at`, `updated_at`) VALUES
(7, 9, NULL, 10, 1, '10.00000000', 'level 1 Referral Commission From 01911105801', 'login', '4f15b0b7-75dc-4000-b6f7-125b4a05ed00', '2021-03-08 04:22:52', '2021-03-08 04:22:52');

-- --------------------------------------------------------

--
-- Table structure for table `contacts`
--

CREATE TABLE `contacts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `subject` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `message` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `contacts`
--

INSERT INTO `contacts` (`id`, `name`, `email`, `subject`, `message`, `created_at`, `updated_at`) VALUES
(1, 'Abu Osman', 'dcrownak@email.com', 'How to register', 'How to register How to register How to register How to register How to register How to register', '2021-01-31 01:30:57', '2021-01-31 01:30:57');

-- --------------------------------------------------------

--
-- Table structure for table `contents`
--

CREATE TABLE `contents` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `contents`
--

INSERT INTO `contents` (`id`, `name`, `created_at`, `updated_at`) VALUES
(2, 'feature', '2021-01-27 01:56:36', '2021-01-27 01:56:36'),
(3, 'feature', '2021-01-27 01:58:28', '2021-01-27 01:58:28'),
(4, 'feature', '2021-01-27 05:07:27', '2021-01-27 05:07:27'),
(5, 'about-us', '2021-01-27 05:11:15', '2021-01-27 05:11:15'),
(6, 'about-us', '2021-01-27 05:12:24', '2021-01-27 05:12:24'),
(7, 'services', '2021-01-27 05:23:07', '2021-01-27 05:23:07'),
(8, 'services', '2021-01-27 05:23:29', '2021-01-27 05:23:29'),
(9, 'services', '2021-01-27 05:23:46', '2021-01-27 05:23:46'),
(10, 'services', '2021-01-27 05:24:22', '2021-01-27 05:24:22'),
(11, 'services', '2021-01-27 05:24:55', '2021-01-27 05:24:55'),
(12, 'services', '2021-01-27 05:25:18', '2021-01-27 05:25:18'),
(13, 'how-it-works', '2021-01-27 06:42:21', '2021-01-27 06:42:21'),
(14, 'how-it-works', '2021-01-27 06:42:31', '2021-01-27 06:42:31'),
(15, 'how-it-works', '2021-01-27 06:42:45', '2021-01-27 06:42:45'),
(16, 'how-it-works', '2021-01-27 06:43:01', '2021-01-27 06:43:01'),
(17, 'faq', '2021-01-27 06:43:36', '2021-01-27 06:43:36'),
(18, 'faq', '2021-01-27 06:44:45', '2021-01-27 06:44:45'),
(19, 'faq', '2021-01-27 06:44:56', '2021-01-27 06:44:56'),
(20, 'faq', '2021-01-27 06:45:13', '2021-01-27 06:45:13'),
(21, 'faq', '2021-01-27 06:45:26', '2021-01-27 06:45:26'),
(22, 'clients-feedback', '2021-01-28 02:14:47', '2021-01-28 02:14:47'),
(23, 'clients-feedback', '2021-01-28 02:15:44', '2021-01-28 02:15:44'),
(24, 'clients-feedback', '2021-01-28 02:16:15', '2021-01-28 02:16:15'),
(25, 'clients-feedback', '2021-01-28 03:43:50', '2021-01-28 03:43:50'),
(26, 'blog', '2021-01-28 05:33:36', '2021-01-28 05:33:36'),
(27, 'blog', '2021-01-28 05:35:08', '2021-01-28 05:35:08'),
(28, 'blog', '2021-01-28 05:36:28', '2021-01-28 05:36:28'),
(29, 'blog', '2021-01-28 05:37:19', '2021-01-28 05:37:19'),
(30, 'contact', '2021-01-30 05:38:08', '2021-01-30 05:38:08'),
(31, 'contact', '2021-01-30 05:39:03', '2021-01-30 05:39:03'),
(32, 'contact', '2021-01-30 05:39:47', '2021-01-30 05:39:47'),
(33, 'social-links', '2021-01-30 06:53:34', '2021-01-30 06:53:34'),
(34, 'social-links', '2021-01-30 07:20:36', '2021-01-30 07:20:36'),
(35, 'social-links', '2021-01-30 07:20:50', '2021-01-30 07:20:50'),
(36, 'social-links', '2021-01-30 07:21:18', '2021-01-30 07:21:18'),
(37, 'social-links', '2021-01-30 07:21:32', '2021-01-30 07:21:32');

-- --------------------------------------------------------

--
-- Table structure for table `content_details`
--

CREATE TABLE `content_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `content_id` bigint(20) UNSIGNED DEFAULT NULL,
  `language_id` bigint(20) UNSIGNED DEFAULT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `content_details`
--

INSERT INTO `content_details` (`id`, `content_id`, `language_id`, `description`, `created_at`, `updated_at`) VALUES
(2, 2, 1, '{\"title\":\"Fast Payments\",\"short_description\":\"<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt<br \\/><\\/p>\"}', '2021-01-27 01:56:36', '2021-01-27 01:56:36'),
(3, 3, 1, '{\"title\":\"Different Wallet\",\"short_description\":\"<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt<br \\/><\\/p>\"}', '2021-01-27 01:58:28', '2021-01-27 01:58:28'),
(5, 2, 2, '{\"title\":\"Pagos r\\u00e1pidos\",\"short_description\":\"<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt<br \\/><\\/p>\"}', '2021-01-27 05:04:37', '2021-01-27 23:17:39'),
(6, 3, 2, '{\"title\":\"Cartera diferente\",\"short_description\":\"<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt<br \\/><\\/p>\"}', '2021-01-27 05:06:06', '2021-01-27 23:17:57'),
(7, 4, 1, '{\"title\":\"Multiple Currency\",\"short_description\":\"<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt<br \\/><\\/p>\"}', '2021-01-27 05:07:27', '2021-01-27 05:08:03'),
(8, 4, 2, '{\"title\":\"Moneda m\\u00faltiple\",\"short_description\":\"<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt<br \\/><\\/p>\"}', '2021-01-27 05:07:56', '2021-01-27 23:18:19'),
(9, 5, 1, '{\"title\":\"Our Mission\",\"short_description\":\"<p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Magni, velit. \\r\\nFacere pariatur iste cupiditaterea, animi nihil dolor iusto amet erro \\r\\nlibero aut deleniti quas laboriosam accusamus<br \\/><\\/p>\"}', '2021-01-27 05:11:15', '2021-01-27 05:11:15'),
(10, 5, 2, '{\"title\":\"Nuestra misi\\u00f3n\",\"short_description\":\"<p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Magni, velit. Facere pariatur iste cupiditaterea, animi nihil dolor iusto amet erro libero aut deleniti quas laboriosam accusamus<br \\/><\\/p>\"}', '2021-01-27 05:11:55', '2021-01-27 23:18:46'),
(11, 6, 1, '{\"title\":\"Our Visions\",\"short_description\":\"<p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Magni, velit. \\r\\nFacere pariatur iste cupiditaterea, animi nihil dolor iusto amet erro \\r\\nlibero aut deleniti quas<br \\/><\\/p>\"}', '2021-01-27 05:12:24', '2021-01-27 05:12:24'),
(12, 6, 2, '{\"title\":\"Nuestras Visiones\",\"short_description\":\"<p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Magni, velit. Facere pariatur iste cupiditaterea, animi nihil dolor iusto amet erro libero aut deleniti quas laboriosam accusamus<br \\/><\\/p>\"}', '2021-01-27 05:12:48', '2021-01-27 23:19:08'),
(13, 7, 1, '{\"title\":\"Send Money\",\"short_description\":\"<p>Lorem ipsum dolor sit amet,quam maxi consectetur adipiscing sit elit. \\r\\nNulla neque quam, maxi ut accumsan ut, posuere sit Lorem ipsum<br \\/><\\/p>\"}', '2021-01-27 05:23:07', '2021-01-27 05:23:07'),
(14, 8, 1, '{\"title\":\"Payment Online\",\"short_description\":\"<p>Lorem ipsum dolor sit amet,quam maxi consectetur adipiscing sit elit. \\r\\nNulla neque quam, maxi ut accumsan ut, posuere sit Lorem ipsum<br \\/><\\/p>\"}', '2021-01-27 05:23:29', '2021-01-27 05:23:29'),
(15, 9, 1, '{\"title\":\"Receive Money\",\"short_description\":\"<p>Lorem ipsum dolor sit amet,quam maxi consectetur adipiscing sit elit. \\r\\nNulla neque quam, maxi ut accumsan ut, posuere sit Lorem ipsum<br \\/><\\/p>\"}', '2021-01-27 05:23:46', '2021-01-27 05:23:46'),
(16, 10, 1, '{\"title\":\"Withdraw\",\"short_description\":\"<p>Lorem ipsum dolor sit amet,quam maxi consectetur adipiscing sit elit. \\r\\nNulla neque quam, maxi ut accumsan ut, posuere sit Lorem ipsum<br \\/><\\/p>\"}', '2021-01-27 05:24:22', '2021-01-27 05:24:22'),
(17, 11, 1, '{\"title\":\"Cash Board\",\"short_description\":\"<p>Lorem ipsum dolor sit amet,quam maxi consectetur adipiscing sit elit. \\r\\nNulla neque quam, maxi ut accumsan ut, posuere sit Lorem ipsum<br \\/><\\/p>\"}', '2021-01-27 05:24:55', '2021-01-27 05:24:55'),
(18, 12, 1, '{\"title\":\"Deposit\",\"short_description\":\"<p>Lorem ipsum dolor sit amet,quam maxi consectetur adipiscing sit elit. \\r\\nNulla neque quam, maxi ut accumsan ut, posuere sit Lorem ipsum<br \\/><\\/p>\"}', '2021-01-27 05:25:18', '2021-01-27 23:22:12'),
(19, 7, 2, '{\"title\":\"Enviar dinero\",\"short_description\":\"<p>Lorem ipsum dolor sit amet,quam maxi consectetur adipiscing sit elit. Nulla neque quam, maxi ut accumsan ut, posuere sit Lorem ipsum<br \\/><\\/p>\"}', '2021-01-27 05:26:07', '2021-01-27 23:19:57'),
(20, 8, 2, '{\"title\":\"Pago en l\\u00ednea\",\"short_description\":\"<p>Lorem ipsum dolor sit amet,quam maxi consectetur adipiscing sit elit. Nulla neque quam, maxi ut accumsan ut, posuere sit Lorem ipsum<br \\/><\\/p>\"}', '2021-01-27 05:27:10', '2021-01-27 23:20:18'),
(21, 9, 2, '{\"title\":\"Recibir dinero\",\"short_description\":\"<p>Lorem ipsum dolor sit amet,quam maxi consectetur adipiscing sit elit. Nulla neque quam, maxi ut accumsan ut, posuere sit Lorem ipsum<br \\/><\\/p>\"}', '2021-01-27 05:27:27', '2021-01-27 23:20:41'),
(22, 10, 2, '{\"title\":\"Retirar\",\"short_description\":\"<p>Lorem ipsum dolor sit amet,quam maxi consectetur adipiscing sit elit. Nulla neque quam, maxi ut accumsan ut, posuere sit Lorem ipsum<br \\/><\\/p>\"}', '2021-01-27 05:27:47', '2021-01-27 23:21:05'),
(23, 11, 2, '{\"title\":\"Junta de caja\",\"short_description\":\"<p>Lorem ipsum dolor sit amet, quam maxi consectetur adipiscing sit elit. Nulla neque quam, maxi ut accumsan ut, posuere sit Lorem ipsum<br \\/><\\/p>\"}', '2021-01-27 05:28:00', '2021-01-27 23:21:33'),
(24, 12, 2, '{\"title\":\"Depositar\",\"short_description\":\"<p>Lorem ipsum dolor sit amet, quam maxi consectetur adipiscing sit elit. Nulla neque quam, maxi ut accumsan ut, posuere sit Lorem ipsum<br \\/><\\/p>\"}', '2021-01-27 05:28:16', '2021-01-27 23:22:32'),
(25, 13, 1, '{\"title\":\"Login To Our Platform\",\"short_description\":\"<p>Nobis, quasi porro eligendi eoshgju inventore dignissimos, velittre necessitatibus quaerat<br \\/><\\/p>\"}', '2021-01-27 06:42:21', '2021-01-27 06:42:21'),
(26, 14, 1, '{\"title\":\"Information Details\",\"short_description\":\"<p>Nobis, quasi porro eligendi eoshgju inventore dignissimos, velittre necessitatibus quaerat<br \\/><\\/p>\"}', '2021-01-27 06:42:31', '2021-01-27 06:42:31'),
(27, 15, 1, '{\"title\":\"Manage Your Payments\",\"short_description\":\"<p>Nobis, quasi porro eligendi eoshgju inventore dignissimos, velittre necessitatibus quaerat<br \\/><\\/p>\"}', '2021-01-27 06:42:45', '2021-01-27 06:42:45'),
(28, 16, 1, '{\"title\":\"Happy Earnings\",\"short_description\":\"<p>Nobis, quasi porro eligendi eoshgju inventore dignissimos, velittre necessitatibus quaerat\\u00a0 \\u00a0 \\u00a0 \\u00a0 \\u00a0\\u00a0<br \\/><\\/p>\"}', '2021-01-27 06:43:01', '2021-01-27 06:43:01'),
(29, 17, 1, '{\"title\":\"What is the best features?\",\"short_description\":\"<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod\\r\\n tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim \\r\\nveniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea \\r\\ncommodo consequat.<br \\/><\\/p>\"}', '2021-01-27 06:43:36', '2021-01-27 06:43:36'),
(30, 18, 1, '{\"title\":\"Why choose this?\",\"short_description\":\"<p>Why choose this?Why choose this?Why choose this?Why choose this?Why choose this?Why choose this?Why choose this?Why choose this?<br \\/><\\/p>\"}', '2021-01-27 06:44:45', '2021-01-27 06:44:45'),
(31, 19, 1, '{\"title\":\"Purchase license Expire time?\",\"short_description\":\"<p>Purchase license Expire time?Purchase license Expire time?Purchase license Expire time?Purchase license Expire time?Purchase license Expire time?Purchase license Expire time?<br \\/><\\/p>\"}', '2021-01-27 06:44:56', '2021-01-27 06:44:56'),
(32, 20, 1, '{\"title\":\"How can I install?\",\"short_description\":\"<p>How can I install?How can I install?How can I install?How can I install?How can I install?<br \\/><\\/p>\"}', '2021-01-27 06:45:13', '2021-01-27 06:45:13'),
(33, 21, 1, '{\"title\":\"Why this app important to me?\",\"short_description\":\"<p>Why this app important to me?Why this app important to me?Why this app important to me?Why this app important to me?Why this app important to me?Why this app important to me?<br \\/><\\/p>\"}', '2021-01-27 06:45:26', '2021-01-27 06:45:26'),
(34, 17, 2, '{\"title\":\"\\u00bfCu\\u00e1les son las mejores caracter\\u00edsticas?\",\"short_description\":\"<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud ejercicio ullamco laboris nisi ut aliquip ex ea commodo consequat.<br \\/><\\/p>\"}', '2021-01-27 23:11:43', '2021-01-27 23:12:36'),
(35, 18, 2, '{\"title\":\"\\u00bfPor qu\\u00e9 elegir esto?\",\"short_description\":\"<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud ejercicio ullamco laboris nisi ut aliquip ex ea commodo consequat.<br \\/><\\/p>\"}', '2021-01-27 23:12:51', '2021-01-27 23:12:51'),
(36, 19, 2, '{\"title\":\"\\u00bfPor qu\\u00e9 elegir esto?\",\"short_description\":\"<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud ejercicio ullamco laboris nisi ut aliquip ex ea commodo consequat.<br \\/><\\/p>\"}', '2021-01-27 23:13:09', '2021-01-27 23:13:09'),
(37, 20, 2, '{\"title\":\"\\u00bfC\\u00f3mo puedo instalar?\",\"short_description\":\"<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud ejercicio ullamco laboris nisi ut aliquip ex ea commodo consequat.<br \\/><\\/p>\"}', '2021-01-27 23:13:24', '2021-01-27 23:13:24'),
(38, 21, 2, '{\"title\":\"\\u00bfPor qu\\u00e9 esta aplicaci\\u00f3n es importante para m\\u00ed?\",\"short_description\":\"<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud ejercicio ullamco laboris nisi ut aliquip ex ea commodo consequat.<br \\/><\\/p>\"}', '2021-01-27 23:13:36', '2021-01-27 23:13:36'),
(39, 13, 2, '{\"title\":\"Inicie sesi\\u00f3n en su plataforma\",\"short_description\":\"<p>Nosotros, como eoshgju electos, descubrimos adem\\u00e1s necesidades y deseos dignos de velo<br \\/><\\/p>\"}', '2021-01-28 01:09:37', '2021-01-28 01:09:37'),
(40, 14, 2, '{\"title\":\"Detalles de la informaci\\u00f3n\",\"short_description\":\"<p>Nosotros, como eoshgju electos, descubrimos adem\\u00e1s necesidades y deseos dignos de velo<br \\/><\\/p>\"}', '2021-01-28 01:10:19', '2021-01-28 01:10:19'),
(41, 15, 2, '{\"title\":\"Administre sus pagos\",\"short_description\":\"<p>Nosotros, como eoshgju electos, descubrimos adem\\u00e1s necesidades y deseos dignos de velo<br \\/><\\/p>\"}', '2021-01-28 01:10:40', '2021-01-28 01:10:40'),
(42, 16, 2, '{\"title\":\"Felices ganancias\",\"short_description\":\"<p>Nosotros, como eoshgju electos, descubrimos adem\\u00e1s necesidades y deseos dignos de velo<br \\/><\\/p>\"}', '2021-01-28 01:10:52', '2021-01-28 01:10:52'),
(43, 22, 1, '{\"title\":\"Debra Reward\",\"sub_title\":\"Founder\",\"short_description\":\"<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Facere doloribus quibusdam, culpa, ipsum dolore expedita et.<br \\/><\\/p>\"}', '2021-01-28 02:14:47', '2021-01-28 02:14:47'),
(44, 23, 1, '{\"title\":\"Leonardo Bell\",\"sub_title\":\"CEO Onderpi\",\"short_description\":\"<p>Posuere sollicitudin aliquam ultrices sagittis orci a scelerisque. Odio ut enim blandit volutpat. Temr orci dapibus ultrices<br \\/><\\/p>\"}', '2021-01-28 02:15:44', '2021-01-28 02:15:44'),
(45, 24, 1, '{\"title\":\"Kate Thompson\",\"sub_title\":\"CEO Foograf\",\"short_description\":\"<p>Quam vulputate dignissim suspendisse in est ante in nibh. Iaculis urna id volutpat lacus lao abitur gravida arcu.<br \\/><\\/p>\"}', '2021-01-28 02:16:15', '2021-01-28 02:16:15'),
(46, 22, 2, '{\"title\":\"Recompensa Debra\",\"sub_title\":\"fundador\",\"short_description\":\"<p><span>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Para hacerlo de sus dolores en algunos casos, la culpa es muy f\\u00e1cil y sin dolor.<\\/span><br \\/><\\/p>\"}', '2021-01-28 02:18:41', '2021-01-28 02:18:41'),
(47, 23, 2, '{\"title\":\"Leonard Bell\",\"sub_title\":\"CEO Onderpi\",\"short_description\":\"<p>Ponga unas flechas vengadoras de cuidados cl\\u00ednicos del chocolate. Para blandit volutpat odio ut. Baloncesto proteico cl\\u00ednico temra<\\/p>\"}', '2021-01-28 02:19:44', '2021-01-28 02:19:44'),
(48, 24, 2, '{\"title\":\"Kate Thompson\",\"sub_title\":\"CEO Foograf\",\"short_description\":\"<p>C\\u00f3mo Vulputate soccer bowl en el semper delantero. Pasa los lagos lao id volutpat iaculis urna gravida arcu.<\\/p>\"}', '2021-01-28 03:40:39', '2021-01-28 03:40:39'),
(49, 25, 1, '{\"title\":\"Thompson Kate\",\"sub_title\":\"Foograf CEO\",\"short_description\":\"<p><span>Quam vulputate dignissim suspendisse in est ante in nibh. Iaculis urna id volutpat lacus lao abitur gravida arcu.\\u00a0<\\/span><span>Quam vulputate<\\/span><span>Quam vulputate<\\/span><br \\/><\\/p>\"}', '2021-01-28 03:43:50', '2021-01-28 03:43:50'),
(50, 25, 2, '{\"title\":\"Thompson Kate\",\"sub_title\":\"Foograf CEO\",\"short_description\":\"<p>Quam vulputate dignissim suspendisse in est ante in nibh. Iaculis urna id volutpat lacus lao abitur gravida arcu.\\u00a0Quam vulputateQuam vulputate<br \\/><\\/p>\"}', '2021-01-28 03:44:20', '2021-01-28 03:44:20'),
(51, 26, 1, '{\"title\":\"Protect Your Workplace Strategies Your Cyber Attacks\",\"short_description\":\"<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incidunt ut labor et dolore plicabo. Nemo enim ipsam voluptatem quia voluptas sit aspertur aut odit aut quia consequuntur magni enim Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\\u2019s standard dummy text ever since the 1500s,<\\/p><p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\\u2019s standard dummy text ever since the 1500s, when an unknown printer took.<\\/p><p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\\u2019s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged.<\\/p><p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\\u2019s standard dummy text ever since the 1500s, when an unknown printer took.unchanged.only Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\\u2019s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged.<\\/p>\"}', '2021-01-28 05:33:36', '2021-01-28 05:33:36'),
(52, 26, 2, '{\"title\":\"Proteja sus estrategias en el lugar de trabajo Sus ciberataques\",\"short_description\":\"<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incidunt ut labor et dolore plicabo. Nemo enim ipsam voluptatem quia voluptas sit aspertur aut odit aut quia consequuntur magni enim Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\\u2019s standard dummy text ever since the 1500s,<\\/p><p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\\u2019s standard dummy text ever since the 1500s, when an unknown printer took.<\\/p><p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\\u2019s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged.<\\/p><p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\\u2019s standard dummy text ever since the 1500s, when an unknown printer took.unchanged.only Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\\u2019s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged.<\\/p>\"}', '2021-01-28 05:34:09', '2021-01-28 05:37:45'),
(53, 27, 1, '{\"title\":\"Making Peace With The Feast\",\"short_description\":\"<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incidunt ut labor et dolore plicabo. Nemo enim ipsam voluptatem quia voluptas sit aspertur aut odit aut quia consequuntur magni enim Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\\u2019s standard dummy text ever since the 1500s,<\\/p><p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\\u2019s standard dummy text ever since the 1500s, when an unknown printer took.<\\/p><p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\\u2019s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged.<\\/p><p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\\u2019s standard dummy text ever since the 1500s, when an unknown printer took.unchanged.only Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\\u2019s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged.<\\/p>\"}', '2021-01-28 05:35:08', '2021-01-28 05:38:39'),
(54, 28, 1, '{\"title\":\"Discovery Incommode\",\"short_description\":\"<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incidunt ut labor et dolore plicabo. Nemo enim ipsam voluptatem quia voluptas sit aspertur aut odit aut quia consequuntur magni enim Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\\u2019s standard dummy text ever since the 1500s,<\\/p><p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\\u2019s standard dummy text ever since the 1500s, when an unknown printer took.<\\/p><p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\\u2019s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged.<\\/p><p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\\u2019s standard dummy text ever since the 1500s, when an unknown printer took.unchanged.only Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\\u2019s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged.<\\/p>\"}', '2021-01-28 05:36:28', '2021-01-28 05:36:28'),
(55, 29, 1, '{\"title\":\"Mobile Friendliness\",\"short_description\":\"<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incidunt ut labor et dolore plicabo. Nemo enim ipsam voluptatem quia voluptas sit aspertur aut odit aut quia consequuntur magni enim Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\\u2019s standard dummy text ever since the 1500s,<\\/p><p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\\u2019s standard dummy text ever since the 1500s, when an unknown printer took.<\\/p><p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\\u2019s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged.<\\/p><p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\\u2019s standard dummy text ever since the 1500s, when an unknown printer took.unchanged.only Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\\u2019s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged.<\\/p>\"}', '2021-01-28 05:37:19', '2021-01-28 05:37:19'),
(56, 27, 2, '{\"title\":\"Hacer las paces con la fiesta\",\"short_description\":\"<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incidunt ut labor et dolore plicabo. Nemo enim ipsam voluptatem quia voluptas sit aspertur aut odit aut quia consequuntur magni enim Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\\u2019s standard dummy text ever since the 1500s,<\\/p><p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\\u2019s standard dummy text ever since the 1500s, when an unknown printer took.<\\/p><p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\\u2019s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged.<\\/p><p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\\u2019s standard dummy text ever since the 1500s, when an unknown printer took.unchanged.only Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\\u2019s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged.<\\/p>\"}', '2021-01-28 05:38:22', '2021-01-28 05:38:22'),
(57, 28, 2, '{\"title\":\"Discovery Incommode\",\"short_description\":\"<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incidunt ut labor et dolore plicabo. Nemo enim ipsam voluptatem quia voluptas sit aspertur aut odit aut quia consequuntur magni enim Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\\u2019s standard dummy text ever since the 1500s,<\\/p><p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\\u2019s standard dummy text ever since the 1500s, when an unknown printer took.<\\/p><p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\\u2019s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged.<\\/p><p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\\u2019s standard dummy text ever since the 1500s, when an unknown printer took.unchanged.only Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\\u2019s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged.<\\/p>\"}', '2021-01-28 05:39:12', '2021-01-28 05:39:12'),
(58, 29, 2, '{\"title\":\"Amabilidad m\\u00f3vil\",\"short_description\":\"<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incidunt ut labor et dolore plicabo. Nemo enim ipsam voluptatem quia voluptas sit aspertur aut odit aut quia consequuntur magni enim Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\\u2019s standard dummy text ever since the 1500s,<\\/p><p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\\u2019s standard dummy text ever since the 1500s, when an unknown printer took.<\\/p><p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\\u2019s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged.<\\/p><p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\\u2019s standard dummy text ever since the 1500s, when an unknown printer took.unchanged.only Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\\u2019s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged.<\\/p>\"}', '2021-01-28 05:39:28', '2021-01-28 05:39:28'),
(59, 30, 1, '{\"title\":\"Address\",\"short_description\":\"CA 560 Bush St &amp; 20th Ave, Apt 5 San Francisco, 230909, Canada\"}', '2021-01-30 05:38:08', '2021-02-10 05:38:52'),
(60, 31, 1, '{\"title\":\"Email\",\"short_description\":\"wallet@email.com<br \\/>fax@email.com\"}', '2021-01-30 05:39:03', '2021-02-10 05:40:32'),
(61, 32, 1, '{\"title\":\"Phone\",\"short_description\":\"+88 587 154756<br \\/>+44 5555 14574\"}', '2021-01-30 05:39:47', '2021-02-10 05:39:50');

-- --------------------------------------------------------

--
-- Table structure for table `content_media`
--

CREATE TABLE `content_media` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `content_id` bigint(20) UNSIGNED DEFAULT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `content_media`
--

INSERT INTO `content_media` (`id`, `content_id`, `description`, `created_at`, `updated_at`) VALUES
(2, 2, '{\"image\":\"601148696e8971611745385.png\"}', '2021-01-27 01:56:36', '2021-01-27 05:03:05'),
(3, 3, '{\"image\":\"6011492d87a6d1611745581.png\"}', '2021-01-27 01:58:28', '2021-01-27 05:06:21'),
(4, 4, '{\"image\":\"6011496fa80921611745647.png\"}', '2021-01-27 05:07:27', '2021-01-27 05:07:27'),
(5, 7, '{\"image\":\"6016a5908e89c1612096912.png\"}', '2021-01-27 05:23:07', '2021-01-31 06:41:52'),
(6, 8, '{\"image\":\"60114d31af7b41611746609.png\"}', '2021-01-27 05:23:29', '2021-01-27 05:23:29'),
(7, 9, '{\"image\":\"60114d424d7421611746626.png\"}', '2021-01-27 05:23:46', '2021-01-27 05:23:46'),
(8, 10, '{\"image\":\"60114d66e6c231611746662.png\"}', '2021-01-27 05:24:22', '2021-01-27 05:24:22'),
(9, 11, '{\"image\":\"60114d87647141611746695.png\"}', '2021-01-27 05:24:55', '2021-01-27 05:24:55'),
(10, 12, '{\"image\":\"60114d9ebeab41611746718.png\"}', '2021-01-27 05:25:18', '2021-01-27 05:25:18'),
(11, 22, '{\"image\":\"601274a8ea4801611822248.png\"}', '2021-01-28 02:14:47', '2021-01-28 02:24:08'),
(12, 23, '{\"image\":\"60127b49855861611823945.png\"}', '2021-01-28 02:15:44', '2021-01-28 02:52:25'),
(13, 24, '{\"image\":\"60127b4e99f2e1611823950.png\"}', '2021-01-28 02:16:15', '2021-01-28 02:52:30'),
(14, 25, '{\"image\":\"60128756a35a41611827030.jpg\"}', '2021-01-28 03:43:50', '2021-01-28 03:43:50'),
(15, 26, '{\"image\":\"6012a11029aa61611833616.jpg\"}', '2021-01-28 05:33:36', '2021-01-28 05:33:36'),
(16, 27, '{\"image\":\"6012a16cbcb971611833708.jpg\"}', '2021-01-28 05:35:08', '2021-01-28 05:35:08'),
(17, 28, '{\"image\":\"6012a1bc3daac1611833788.jpg\"}', '2021-01-28 05:36:28', '2021-01-28 05:36:28'),
(18, 29, '{\"image\":\"6012a1ef765d51611833839.jpg\"}', '2021-01-28 05:37:19', '2021-01-28 05:37:19'),
(19, 30, '{\"image\":\"6023c938d35be1612958008.png\"}', '2021-01-30 05:38:08', '2021-02-10 05:53:28'),
(20, 31, '{\"image\":\"6023c6ce6392c1612957390.png\"}', '2021-01-30 05:39:03', '2021-02-10 05:43:10'),
(21, 32, '{\"image\":\"6023c6bca091e1612957372.png\"}', '2021-01-30 05:39:47', '2021-02-10 05:42:52'),
(22, 33, '{\"social_icon\":\"fab fa-facebook-f\",\"social_link\":\"https:\\/\\/victor-valencia.github.io\\/bootstrap-iconpicker\\/\"}', '2021-01-30 06:53:34', '2021-01-30 07:20:14'),
(23, 34, '{\"social_icon\":\"fab fa-twitter\",\"social_link\":\"https:\\/\\/victor-valencia.github.io\\/bootstrap-iconpicker\\/\"}', '2021-01-30 07:20:36', '2021-01-30 07:20:36'),
(24, 35, '{\"social_icon\":\"fab fa-google-plus-g\",\"social_link\":\"https:\\/\\/victor-valencia.github.io\\/bootstrap-iconpicker\\/\"}', '2021-01-30 07:20:50', '2021-01-30 07:20:50'),
(25, 36, '{\"social_icon\":\"fab fa-pinterest-p\",\"social_link\":\"https:\\/\\/victor-valencia.github.io\\/bootstrap-iconpicker\\/\"}', '2021-01-30 07:21:18', '2021-01-30 07:21:18'),
(26, 37, '{\"social_icon\":\"fab fa-instagram\",\"social_link\":\"https:\\/\\/victor-valencia.github.io\\/bootstrap-iconpicker\\/\"}', '2021-01-30 07:21:32', '2021-01-30 07:21:32');

-- --------------------------------------------------------

--
-- Table structure for table `currencies`
--

CREATE TABLE `currencies` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `symbol` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `code` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `logo` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `exchange_rate` decimal(20,8) NOT NULL DEFAULT 0.00000000,
  `is_active` tinyint(4) NOT NULL DEFAULT 1 COMMENT '1 = active, 0 = inactive',
  `currency_type` tinyint(4) NOT NULL DEFAULT 1 COMMENT '0 = crypto, 1 = Fiat',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `currencies`
--

INSERT INTO `currencies` (`id`, `name`, `symbol`, `code`, `logo`, `exchange_rate`, `is_active`, `currency_type`, `created_at`, `updated_at`) VALUES
(1, 'US Doller', '$', 'USD', 'usd.jpeg', '1.00000000', 1, 1, '2020-11-12 03:14:08', '2021-02-03 04:40:18'),
(2, 'Bangladeshi Taka', '৳', 'BDT', 'bdt.png', '84.66000000', 1, 1, '2020-11-12 03:14:55', '2021-02-03 04:40:18'),
(3, 'British pound', '£', 'GBP', 'gbp.png', '0.73000000', 1, 1, '2020-11-18 02:15:42', '2021-02-03 04:40:18'),
(4, 'BITCOIN', '฿', 'BTC', 'btc.png', '35823.77686565', 1, 0, '2021-01-20 01:49:09', '2021-02-03 04:40:20');

-- --------------------------------------------------------

--
-- Table structure for table `deposits`
--

CREATE TABLE `deposits` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `depositable_id` int(11) DEFAULT NULL,
  `depositable_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `currency_id` bigint(20) UNSIGNED DEFAULT NULL,
  `charges_limit_id` bigint(20) UNSIGNED DEFAULT NULL,
  `payment_method_id` bigint(20) UNSIGNED DEFAULT NULL,
  `payment_method_currency` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `amount` decimal(18,8) NOT NULL DEFAULT 0.00000000,
  `percentage` decimal(8,4) NOT NULL DEFAULT 0.0000 COMMENT 'Percent of charge',
  `charge_percentage` decimal(18,8) NOT NULL DEFAULT 0.00000000 COMMENT 'After adding percent of charge',
  `charge_fixed` decimal(18,8) NOT NULL DEFAULT 0.00000000,
  `charge` decimal(18,8) NOT NULL DEFAULT 0.00000000 COMMENT 'Total charge',
  `payable_amount` decimal(18,8) NOT NULL DEFAULT 0.00000000 COMMENT 'Amount payed',
  `btc_amount` decimal(18,8) DEFAULT NULL,
  `btc_wallet` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `utr` char(36) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 0 COMMENT '1=Success,0=Pending',
  `note` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `deposits`
--

INSERT INTO `deposits` (`id`, `depositable_id`, `depositable_type`, `user_id`, `currency_id`, `charges_limit_id`, `payment_method_id`, `payment_method_currency`, `amount`, `percentage`, `charge_percentage`, `charge_fixed`, `charge`, `payable_amount`, `btc_amount`, `btc_wallet`, `utr`, `status`, `note`, `email`, `created_at`, `updated_at`) VALUES
(1, 1, 'App\\Models\\Fund', 1, 1, 22, 1, 'USD', '10.00000000', '0.8000', '0.08000000', '1.00000000', '1.08000000', '55.40000000', NULL, NULL, 'wmn9zBDTUDBd3o6N', 1, NULL, 'dcrownak@gmail.com', '2021-01-12 04:05:25', '2021-01-12 04:06:13'),
(2, 2, 'App\\Models\\Fund', 1, 3, 22, 1, 'USD', '10.00000000', '0.8000', '0.08000000', '1.00000000', '1.08000000', '55.40000000', NULL, NULL, 'XgZ7kP98GN3QRf8C', 1, NULL, 'dcrownak@gmail.com', '2021-01-12 04:10:26', '2021-01-12 04:10:51'),
(3, 3, 'App\\Models\\Fund', 1, 2, 23, 2, 'USD', '10.00000000', '1.0000', '0.10000000', '2.00000000', '2.10000000', '12.10000000', NULL, NULL, 'TIOLlH52wkoLXzf4', 1, NULL, 'dcrownak@gmail.com', '2021-01-12 04:12:38', '2021-01-12 04:13:44'),
(4, NULL, 'App\\Models\\Fund', 1, 1, 33, 12, 'USD', '10.00000000', '1.5000', '0.15000000', '2.00000000', '2.15000000', '12.15000000', NULL, NULL, 'Ht4ReExPde7W8ZDP', 0, NULL, 'dcrownak@gmail.com', '2021-01-12 04:47:14', '2021-01-12 04:47:14'),
(5, NULL, 'App\\Models\\Fund', 1, 1, 42, 14, 'USD', '10.00000000', '0.5000', '0.05000000', '0.90000000', '0.95000000', '10.95000000', NULL, NULL, 'dBKDVmPr9dl5PTrr', 0, NULL, 'dcrownak@gmail.com', '2021-01-12 23:23:08', '2021-01-12 23:23:08'),
(6, 4, 'App\\Models\\Fund', 1, 1, 38, 20, 'NGN', '10.00000000', '0.5000', '0.05000000', '1.60000000', '1.65000000', '4441.56250000', NULL, NULL, 'qfSUL9XSrGm6G3cA', 1, NULL, 'dcrownak@gmail.com', '2021-01-13 04:09:39', '2021-01-13 04:10:07'),
(7, NULL, 'App\\Models\\Fund', 1, 1, 32, 10, 'INR', '10.00000000', '1.0000', '0.10000000', '1.50000000', '1.60000000', '846.80000000', NULL, NULL, 'Dnqhebth0JPP81eE', 0, NULL, 'dcrownak@gmail.com', '2021-01-13 05:02:07', '2021-01-13 05:02:07'),
(8, NULL, 'App\\Models\\Voucher', NULL, 1, 22, 1, 'USD', '10.00000000', '0.8000', '0.08000000', '1.00000000', '1.08000000', '55.40000000', NULL, NULL, 'o7i3q94u7SPAExwU', 0, NULL, 'dcrownak@yahoo.com', '2021-01-13 05:42:04', '2021-01-13 05:42:04'),
(9, NULL, 'App\\Models\\Voucher', NULL, 1, 22, 1, 'USD', '10.00000000', '0.8000', '0.08000000', '1.00000000', '1.08000000', '55.40000000', NULL, NULL, 'pGpNSgaINOO5ZWLl', 1, NULL, 'dcrownak@yahoo.com', '2021-01-13 05:46:00', '2021-01-13 05:53:35'),
(10, 2, 'App\\Models\\Voucher', NULL, 1, 22, 1, 'USD', '10.00000000', '0.8000', '0.08000000', '1.00000000', '1.08000000', '55.40000000', NULL, NULL, 'mpgOKNO5sPj3m1z4', 1, NULL, 'dcrownak@dcrownak.com', '2021-01-13 06:16:27', '2021-01-13 06:17:54'),
(11, NULL, 'App\\Models\\Fund', 1, 1, 64, 25, 'PKR', '10.00000000', '0.5000', '0.05000000', '0.60000000', '0.65000000', '1704.00000000', NULL, NULL, 'ziouWTWnL3wTam2f', 0, NULL, 'dcrownak@gmail.com', '2021-01-14 02:32:25', '2021-01-14 02:32:25'),
(12, NULL, 'App\\Models\\Fund', 1, 1, 64, 25, 'PKR', '10.00000000', '0.5000', '0.05000000', '0.60000000', '0.65000000', '1704.00000000', NULL, NULL, 'KgAiWKpOUsQiHX0N', 0, NULL, 'dcrownak@gmail.com', '2021-01-14 02:35:00', '2021-01-14 02:35:00'),
(13, NULL, 'App\\Models\\Fund', 1, 1, 64, 25, 'PKR', '10.00000000', '0.5000', '0.05000000', '0.60000000', '0.65000000', '1704.00000000', NULL, NULL, 'GqgEP3h4dBSlLXEx', 0, NULL, 'dcrownak@gmail.com', '2021-01-14 02:43:25', '2021-01-14 02:43:25'),
(14, 2, 'App\\Models\\Voucher', NULL, 1, 64, 25, 'PKR', '10.00000000', '0.5000', '0.05000000', '0.60000000', '0.65000000', '1704.00000000', NULL, NULL, 'b5OprfB88jOI1OU0', 0, NULL, 'dcrownak@dcrownak.com', '2021-01-14 02:48:24', '2021-01-14 02:48:24'),
(15, 2, 'App\\Models\\Voucher', NULL, 1, 64, 25, 'PKR', '10.00000000', '0.5000', '0.05000000', '0.60000000', '0.65000000', '1704.00000000', NULL, NULL, '4WF6buc6jaB9eCLV', 0, NULL, 'dcrownak@dcrownak.com', '2021-01-14 02:50:18', '2021-01-14 02:50:18'),
(16, 3, 'App\\Models\\Voucher', NULL, 1, 23, 2, 'USD', '10.00000000', '1.0000', '0.10000000', '2.00000000', '2.10000000', '12.10000000', NULL, NULL, 'fHmnB8jgKoiwO4Hu', 1, NULL, 'osman_s1986@gmail.com', '2021-01-17 01:44:44', '2021-01-17 01:45:27'),
(17, NULL, 'App\\Models\\Fund', 1, 1, 40, 16, 'INR', '10.00000000', '1.0000', '0.10000000', '1.00000000', '1.10000000', '810.30000000', NULL, NULL, 'dwX6VuH6qUY88h8f', 0, NULL, 'dcrownak@gmail.com', '2021-01-19 00:21:51', '2021-01-19 00:21:51'),
(18, NULL, 'App\\Models\\Fund', 1, 1, 64, 25, 'PKR', '10.00000000', '0.5000', '0.05000000', '0.60000000', '0.65000000', '1704.00000000', NULL, NULL, 'ZewLkftOJFzmxAOw', 0, NULL, 'dcrownak@gmail.com', '2021-02-09 03:50:51', '2021-02-09 03:50:51'),
(19, NULL, 'App\\Models\\Fund', 1, 1, 23, 2, 'USD', '10.00000000', '1.0000', '0.10000000', '2.00000000', '2.10000000', '12.10000000', NULL, NULL, 'L36z8T0jghvdp0m7', 0, NULL, 'dcrownak@gmail.com', '2021-03-14 06:55:07', '2021-03-14 06:55:07');

-- --------------------------------------------------------

--
-- Table structure for table `disputes`
--

CREATE TABLE `disputes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `disputable_id` bigint(20) DEFAULT NULL,
  `disputable_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `utr` char(36) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(4) DEFAULT 0 COMMENT '0 = open,1 = solved,2 = closed',
  `defender_reply_yn` tinyint(4) DEFAULT NULL COMMENT '0 = No, 1 = Yes',
  `claimer_reply_yn` tinyint(4) DEFAULT NULL COMMENT '0 = No, 1 = Yes',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `disputes`
--

INSERT INTO `disputes` (`id`, `disputable_id`, `disputable_type`, `utr`, `status`, `defender_reply_yn`, `claimer_reply_yn`, `created_at`, `updated_at`) VALUES
(2, 2, 'App\\Models\\Escrow', '4e7d5573-4635-4fbc-af20-a6512d1e76c7', 1, 0, 1, '2021-01-18 23:26:02', '2021-01-19 01:40:20');

-- --------------------------------------------------------

--
-- Table structure for table `dispute_details`
--

CREATE TABLE `dispute_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `dispute_id` bigint(20) UNSIGNED DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `admin_id` bigint(20) UNSIGNED DEFAULT NULL,
  `status` tinyint(4) DEFAULT NULL COMMENT '0 = user replied ,1 = admin replied',
  `message` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `files` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `action` tinyint(4) DEFAULT NULL COMMENT '0 = solved,1 = closed,2 = mute,3 = unmute',
  `utr` char(36) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `dispute_details`
--

INSERT INTO `dispute_details` (`id`, `dispute_id`, `user_id`, `admin_id`, `status`, `message`, `files`, `action`, `utr`, `created_at`, `updated_at`) VALUES
(42, 2, 1, NULL, 0, 'ami taka dimu na ... product pai nai', NULL, NULL, '51e480d7-7902-436b-80c7-d0504fecf060', '2021-01-18 23:26:02', '2021-01-18 23:26:02'),
(48, 2, NULL, 1, 1, 'tumi ki product daoni?', NULL, NULL, 'afd0da53-356e-4c1e-a884-5148fbafaf7c', '2021-01-18 23:43:04', '2021-01-18 23:43:04'),
(49, 2, 2, NULL, 0, 'Disilam to ...she oshikar kore', NULL, NULL, 'f3c17472-8094-473c-9ba3-fe00f6ad3519', '2021-01-18 23:43:44', '2021-01-18 23:43:44'),
(50, 2, 2, 1, 1, NULL, NULL, 2, 'b9875986-ab4b-4a91-a78f-22bcd5d8b652', '2021-01-18 23:44:19', '2021-01-18 23:44:19'),
(51, 2, NULL, 1, 1, NULL, NULL, 0, '73e8c6fc-6286-4368-a853-86e5182502b7', '2021-01-18 23:53:32', '2021-01-18 23:53:32'),
(53, 2, NULL, 1, 1, NULL, NULL, 0, 'e4fb99db-8341-4202-9264-ce0dd4a87c33', '2021-01-19 01:40:20', '2021-01-19 01:40:20');

-- --------------------------------------------------------

--
-- Table structure for table `email_templates`
--

CREATE TABLE `email_templates` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `language_id` bigint(20) UNSIGNED DEFAULT NULL,
  `template_key` varchar(120) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_from` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `subject` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `template` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sms_body` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `short_keys` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mail_status` tinyint(1) NOT NULL DEFAULT 0,
  `sms_status` tinyint(1) NOT NULL DEFAULT 0,
  `lang_code` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `email_templates`
--

INSERT INTO `email_templates` (`id`, `language_id`, `template_key`, `email_from`, `name`, `subject`, `template`, `sms_body`, `short_keys`, `mail_status`, `sms_status`, `lang_code`, `created_at`, `updated_at`) VALUES
(1, 1, 'TRANSFER_TO', 'support@binary.com', 'Send money to', 'Your Account has been credited', '[[sender]] send money to your account amount [[amount]] [[currency]] . Transaction: #[[transaction]]', '[[sender]] send money to your account amount [[amount]] [[currency]] . Transaction: #[[transaction]]', '{\"sender\":\"Sender Name\",\"amount\":\"Received Amount\",\"currency\":\"Transfer Currency\",\"transaction\":\"Transaction Number\"}', 1, 1, 'en', NULL, NULL),
(2, 1, 'TRANSFER_FROM', 'support@binary.com', 'Send money from', 'Your Account has been debited', 'You have send money to [[receiver]] account amount [[amount]] [[currency]].Transaction: #[[transaction]]', 'You have send money to [[receiver]] account amount [[amount]] [[currency]].Transaction: #[[transaction]]', '{\"receiver\":\"Receiver Name\",\"amount\":\"Send Amount\",\"currency\":\"Transfer Currency\",\"transaction\":\"Transaction Number\"}', 1, 1, 'en', NULL, NULL),
(3, 1, 'REQUEST_MONEY_INIT', 'support@binary.com', 'Request Money Initialise', 'Request to send money', '[[sender]] request for send money to account amount [[amount]] [[currency]] . Transaction: #[[transaction]]', '[[sender]] request for send money to account amount [[amount]] [[currency]] . Transaction: #[[transaction]]', '{\"sender\":\"Sender Name\",\"amount\":\"Request Amount\",\"currency\":\"Request Currency\",\"transaction\":\"Transaction Number\"}', 1, 1, 'en', NULL, NULL),
(4, 1, 'REQUEST_MONEY_CONFIRM', 'support@binary.com', 'Request Money Confirm', 'Request to send money', '[[sender]] confirm your request money amount [[amount]] [[currency]] . Transaction: #[[transaction]]', '[[sender]] confirm your request money amount [[amount]] [[currency]] . Transaction: #[[transaction]]', '{\"sender\":\"Sender Name\",\"amount\":\"Request Amount\",\"currency\":\"Request Currency\",\"transaction\":\"Transaction Number\"}', 1, 1, 'en', NULL, NULL),
(5, 1, 'REQUEST_MONEY_CANCEL', 'support@binary.com', 'Request Money Cancel', 'Request to send money', '[[sender]] cancel your request money amount [[amount]] [[currency]] . Transaction: #[[transaction]]', '[[sender]] cancel your request money amount [[amount]] [[currency]] . Transaction: #[[transaction]]', '{\"sender\":\"Sender Name\",\"amount\":\"Request Amount\",\"currency\":\"Request Currency\",\"transaction\":\"Transaction Number\"}', 1, 1, 'en', NULL, NULL),
(6, 1, 'MONEY_EXCHANGE', 'support@binary.com', 'Money Exchange', 'Exchange Money', 'You are exchange [[from_amount]] [[from_currency]] to [[to_amount]] [[to_currency]]. Transaction: #[[transaction]]', 'You are exchange [[from_amount]] [[from_currency]] to [[to_amount]] [[to_currency]]. Transaction: #[[transaction]]', '{\"from_amount\":\"Amount Exchange From\",\"from_currency\":\"Currency Exchange From\",\"to_amount\":\"Amount Exchange To\",\"to_currency\":\"Currency Exchange To\",\"transaction\":\"Transaction Number\"}', 1, 1, 'en', NULL, NULL),
(7, 1, 'REDEEM_CODE_GENERATE', 'support@binary.com', 'Redeem Code Generate', 'Redeem Code Generate', 'You have generate a redeem code amount [[amount]] [[currency]] . Transaction: #[[transaction]]', 'You have generate a redeem code amount [[amount]] [[currency]] . Transaction: #[[transaction]]', '{\"amount\":\"Request Amount\",\"currency\":\"Request Currency\",\"transaction\":\"Redeem Code\"}', 1, 1, 'en', NULL, NULL),
(8, 1, 'REDEEM_CODE_USED_BY', 'support@binary.com', 'Redeem code used by', 'Redeem Code Used', 'You have used a redeem code amount [[amount]] [[currency]] . Transaction: #[[transaction]]', 'You have used a redeem code amount [[amount]] [[currency]] . Transaction: #[[transaction]]', '{\"amount\":\"Request Amount\",\"currency\":\"Request Currency\",\"transaction\":\"Redeem Code\"}', 1, 1, 'en', NULL, NULL),
(9, 1, 'REDEEM_CODE_SENDER', 'support@binary.com', 'Redeem Code Sender', 'Redeem Code Used', '[[receiver]] used your redeem code amount [[amount]] [[currency]] . Transaction: #[[transaction]]', '[[receiver]] used your redeem code amount [[amount]] [[currency]] . Transaction: #[[transaction]]', '{\"receiver\":\"Receiver Name who used code\",\"amount\":\"Request Amount\",\"currency\":\"Request Currency\",\"transaction\":\"Transaction Number\"}', 1, 1, 'en', NULL, NULL),
(10, 1, 'ESCROW_REQUEST_SENDER', 'support@binary.com', 'Escrow request sender', 'Escrow request initiated', 'Your escrow request to [[receiver]] amount [[amount]] [[currency]] . Transaction: #[[transaction]]', 'Your escrow request to [[receiver]] amount [[amount]] [[currency]] . Transaction: #[[transaction]]', '{\"receiver\":\"Receiver Name\",\"amount\":\"Request Amount\",\"currency\":\"Request Currency\",\"transaction\":\"Transaction Number\"}', 1, 1, 'en', NULL, NULL),
(11, 1, 'ESCROW_REQUEST_RECEIVER', 'support@binary.com', 'Escrow request receiver', 'Escrow request generated', 'You have escrow request from [[sender]] amount [[amount]] [[currency]] . Transaction: #[[transaction]] click to view [[link]]', 'You have escrow request from [[sender]] amount [[amount]] [[currency]] . Transaction: #[[transaction]] click to view [[link]]', '{\"sender\":\"Sender Name\",\"amount\":\"Request Amount\",\"currency\":\"Request Currency\",\"transaction\":\"Transaction Number\",\"link\":\"Action Link\"}', 1, 1, 'en', NULL, NULL),
(12, 1, 'ESCROW_REQUEST_ACCEPT_FROM', 'support@binary.com', 'Escrow Request Accept from', 'Escrow Request Accept from', '[[sender]] accept your request amount [[amount]] [[currency]] . Transaction: #[[transaction]]', '[[sender]] accept your request amount [[amount]] [[currency]] . Transaction: #[[transaction]]', '{\"sender\":\"Request sender Name\",\"amount\":\"Request Amount\",\"currency\":\"Request Currency\",\"transaction\":\"Transaction Number\"}', 1, 1, 'en', NULL, NULL),
(13, 1, 'ESCROW_REQUEST_ACCEPT_BY', 'support@binary.com', 'Escrow Request Accept by', 'Escrow Request Accept by you', 'You accept escrow request amount [[amount]] [[currency]] . Transaction: #[[transaction]]', 'You accept escrow request amount [[amount]] [[currency]] . Transaction: #[[transaction]]', '{\"amount\":\"Request Amount\",\"currency\":\"Request Currency\",\"transaction\":\"Transaction Number\"}', 1, 1, 'en', NULL, NULL),
(14, 1, 'ESCROW_REQUEST_CANCEL_FROM', 'support@binary.com', 'Escrow Request Cancel from', 'Escrow Request Cancel from', '[[sender]] Cancel your request amount [[amount]] [[currency]] . Transaction: #[[transaction]]', '[[sender]] Cancel your request amount [[amount]] [[currency]] . Transaction: #[[transaction]]', '{\"sender\":\"Request sender Name\",\"amount\":\"Request Amount\",\"currency\":\"Request Currency\",\"transaction\":\"Transaction Number\"}', 1, 1, 'en', NULL, NULL),
(15, 1, 'ESCROW_REQUEST_CANCEL_BY', 'support@binary.com', 'Escrow Request Cancel by', 'Escrow Request Cancel by you', 'You Cancel escrow request amount [[amount]] [[currency]] . Transaction: #[[transaction]]', 'You Cancel escrow request amount [[amount]] [[currency]] . Transaction: #[[transaction]]', '{\"amount\":\"Request Amount\",\"currency\":\"Request Currency\",\"transaction\":\"Transaction Number\"}', 1, 1, 'en', NULL, NULL),
(16, 1, 'ESCROW_PAYMENT_DISBURSED_REQUEST_FROM', 'support@binary.com', 'Escrow payment disburse request from', 'Escrow payment disburse request from', '[[sender]] request to disburse your amount [[amount]] [[currency]] . Transaction: #[[transaction]]', '[[sender]] request to disburse your amount [[amount]] [[currency]] . Transaction: #[[transaction]]', '{\"sender\":\"Request sender Name\",\"amount\":\"Request Amount\",\"currency\":\"Request Currency\",\"transaction\":\"Transaction Number\"}', 1, 1, 'en', NULL, NULL),
(17, 1, 'ESCROW_PAYMENT_DISBURSED_REQUEST_BY', 'support@binary.com', 'request to payment disburse request by', 'Escrow payment disburse request by you', 'You request escrow disburse amount [[amount]] [[currency]] . Transaction: #[[transaction]]', 'You request escrow disburse amount [[amount]] [[currency]] . Transaction: #[[transaction]]', '{\"amount\":\"Request Amount\",\"currency\":\"Request Currency\",\"transaction\":\"Transaction Number\"}', 1, 1, 'en', NULL, NULL),
(18, 1, 'ESCROW_PAYMENT_DISBURSED_FROM', 'support@binary.com', 'Escrow payment disburse from', 'Escrow payment disburse from', '[[sender]] disburse your request amount [[amount]] [[currency]] . Transaction: #[[transaction]]', '[[sender]] disburse your request amount [[amount]] [[currency]] . Transaction: #[[transaction]]', '{\"sender\":\"Request sender Name\",\"amount\":\"Request Amount\",\"currency\":\"Request Currency\",\"transaction\":\"Transaction Number\"}', 1, 1, 'en', NULL, NULL),
(19, 1, 'ESCROW_PAYMENT_DISBURSED_BY', 'support@binary.com', 'request to payment disburse by', 'Escrow payment disburse by you', 'You disburse escrow request amount [[amount]] [[currency]] . Transaction: #[[transaction]]', 'You disburse escrow request amount [[amount]] [[currency]] . Transaction: #[[transaction]]', '{\"amount\":\"Request Amount\",\"currency\":\"Request Currency\",\"transaction\":\"Transaction Number\"}', 1, 1, 'en', NULL, NULL),
(20, 1, 'DISPUTE_REQUEST_TO_ADMIN', 'support@binary.com', 'Dispute request to admin', 'Dispute request to admin', '[[sender]] dispute escrow request amount [[amount]] [[currency]] . Transaction: #[[transaction]] click to reply [[link]]', '[[sender]] dispute escrow request amount [[amount]] [[currency]] . Transaction: #[[transaction]] click to reply [[link]]', '{\"sender\":\"Sender Name\",\"amount\":\"Request Amount\",\"currency\":\"Request Currency\",\"transaction\":\"Transaction Number\",\"link\":\"Dispute reply link\"}', 1, 1, 'en', NULL, NULL),
(21, 1, 'DISPUTE_REQUEST_TO_USER', 'support@binary.com', 'Dispute request to user', 'Dispute request to user', '[[sender]] reply dispute escrow request amount. Transaction: #[[transaction]] click to reply [[link]]', '[[sender]] reply dispute escrow request amount. Transaction: #[[transaction]] click to reply [[link]]', '{\"sender\":\"Sender Name\",\"transaction\":\"Transaction Number\",\"link\":\"Dispute reply link\"}', 1, 1, 'en', NULL, NULL),
(22, 1, 'VOUCHER_PAYMENT_REQUEST_TO', 'support@binary.com', 'Voucher payment request to', 'Voucher payment request to', '[[sender]] request to voucher payment amount [[amount]] [[currency]] . Transaction: #[[transaction]] click to payment [[link]]', '[[sender]] request to voucher payment amount [[amount]] [[currency]] . Transaction: #[[transaction]] click to payment [[link]]', '{\"sender\":\"Sender Name\",\"amount\":\"Request Amount\",\"currency\":\"Request Currency\",\"transaction\":\"Transaction Number\",\"link\":\"Dispute reply link\"}', 1, 1, 'en', NULL, NULL),
(23, 1, 'VOUCHER_PAYMENT_REQUEST_FROM', 'support@binary.com', 'Voucher payment request from', 'Voucher payment request from', 'You request to [[receiver]] voucher payment amount [[amount]] [[currency]] . Transaction: #[[transaction]]', 'You request to [[receiver]] voucher payment amount [[amount]] [[currency]] . Transaction: #[[transaction]]', '{\"receiver\":\"Receiver Name\",\"amount\":\"Request Amount\",\"currency\":\"Request Currency\",\"transaction\":\"Transaction Number\"}', 1, 1, 'en', NULL, NULL),
(24, 1, 'VOUCHER_PAYMENT_TO', 'support@binary.com', 'Voucher payment to', 'Voucher payment to', '[[receiver]] payment to your voucher amount [[amount]] [[currency]] . Transaction: #[[transaction]]', '[[receiver]] payment to your voucher amount [[amount]] [[currency]] . Transaction: #[[transaction]]', '{\"receiver\":\"Request receiver name\",\"amount\":\"Request Amount\",\"currency\":\"Request Currency\",\"transaction\":\"Transaction Number\"}', 1, 1, 'en', NULL, NULL),
(25, 1, 'VOUCHER_PAYMENT_FROM', 'support@binary.com', 'Voucher payment from', 'Voucher payment from', 'You payment to [[sender]] voucher amount [[amount]] [[currency]] . Transaction: #[[transaction]]', 'You payment to [[sender]] voucher amount [[amount]] [[currency]] . Transaction: #[[transaction]]', '{\"sender\":\"Request sender Name\",\"amount\":\"Request Amount\",\"currency\":\"Request Currency\",\"transaction\":\"Transaction Number\"}', 1, 1, 'en', NULL, NULL),
(26, 1, 'VOUCHER_PAYMENT_CANCEL_TO', 'support@binary.com', 'Voucher payment cancel to', 'Voucher payment cancel to', '[[receiver]] payment cancel to your voucher amount [[amount]] [[currency]] . Transaction: #[[transaction]]', '[[receiver]] payment cancel to your voucher amount [[amount]] [[currency]] . Transaction: #[[transaction]]', '{\"receiver\":\"Request receiver name\",\"amount\":\"Request Amount\",\"currency\":\"Request Currency\",\"transaction\":\"Transaction Number\"}', 1, 1, 'en', NULL, NULL),
(27, 1, 'VOUCHER_PAYMENT_CANCEL_FROM', 'support@binary.com', 'Voucher payment cancel from', 'Voucher payment cancel from', 'You payment cancel to [[sender]] voucher amount [[amount]] [[currency]] . Transaction: #[[transaction]]', 'You payment cancel to [[sender]] voucher amount [[amount]] [[currency]] . Transaction: #[[transaction]]', '{\"sender\":\"Request sender Name\",\"amount\":\"Request Amount\",\"currency\":\"Request Currency\",\"transaction\":\"Transaction Number\"}', 1, 1, 'en', NULL, NULL),
(28, 1, 'PAYOUT_REQUEST_TO_ADMIN', 'support@binary.com', 'Payout Request Admin', 'Payout Request Admin', '[[sender]] request for payment amount [[amount]] [[currency]] . Transaction: #[[transaction]]', '[[sender]] request for payment amount [[amount]] [[currency]] . Transaction: #[[transaction]]', '{\"sender\":\"Sender Name\",\"amount\":\"Request Amount\",\"currency\":\"Request Currency\",\"transaction\":\"Transaction Number\"}', 1, 1, 'en', NULL, NULL),
(29, 1, 'PAYOUT_REQUEST_FROM', 'support@binary.com', 'Payout Request from', 'Payout Request from', 'You request for payout amount [[amount]] [[currency]] . Transaction: #[[transaction]]', 'You request for payout amount [[amount]] [[currency]] . Transaction: #[[transaction]]', '{\"amount\":\"Request Amount\",\"currency\":\"Request Currency\",\"transaction\":\"Transaction Number\"}', 1, 1, 'en', NULL, NULL),
(30, 1, 'PAYOUT_CONFIRM', 'support@binary.com', 'Payout Confirm', 'Payout Confirm', '[[sender]] confirm your payout amount [[amount]] [[currency]] . Transaction: #[[transaction]]', '[[sender]] confirm your payout amount [[amount]] [[currency]] . Transaction: #[[transaction]]', '{\"sender\":\"Sender Name\",\"amount\":\"Request Amount\",\"currency\":\"Request Currency\",\"transaction\":\"Transaction Number\"}', 1, 1, 'en', NULL, NULL),
(31, 1, 'PAYOUT_CANCEL', 'support@binary.com', 'Payout Cancel', 'Payout Cancel', '[[sender]] cancel your payout amount [[amount]] [[currency]] . Transaction: #[[transaction]]', '[[sender]] cancel your payout amount [[amount]] [[currency]] . Transaction: #[[transaction]]', '{\"sender\":\"Sender Name\",\"amount\":\"Request Amount\",\"currency\":\"Request Currency\",\"transaction\":\"Transaction Number\"}', 1, 1, 'en', NULL, NULL),
(32, 1, 'ADD_FUND_USER_USER', 'support@binary.com', 'Add Fund user user', 'Add fund user', 'you add fund money amount [[amount]] [[currency]] . Transaction: #[[transaction]]', 'you add fund money amount [[amount]] [[currency]] . Transaction: #[[transaction]]', '{\"amount\":\"Request Amount\",\"currency\":\"Request Currency\",\"transaction\":\"Transaction Number\"}', 1, 1, 'en', NULL, NULL),
(33, 1, 'ADD_FUND_USER_ADMIN', 'support@binary.com', 'Add Fund user admin', 'Add fund by user', '[[user]] add fund money amount [[amount]] [[currency]] . Transaction: #[[transaction]]', '[[user]] add fund money amount [[amount]] [[currency]] . Transaction: #[[transaction]]', '{\"user\":\"User full name\",\"amount\":\"Request Amount\",\"currency\":\"Request Currency\",\"transaction\":\"Transaction Number\"}', 1, 1, 'en', NULL, NULL),
(34, 1, 'VERIFICATION_CODE', 'support@binary.com', 'Verification Code', 'verify your email', 'Your email verification code [[code]]', 'Your sms verification code [[code]]', '{\"code\":\"code\"}', 1, 1, 'en', NULL, NULL),
(35, 1, 'DEPOSIT_BONUS', 'support@binary.com', 'Deposit Bonus', 'Deposit Bonus', 'Deposit Commission From [[sender]] amount [[amount]] [[currency]] . Transaction: #[[transaction]]', 'Deposit Commission From [[sender]] amount [[amount]] [[currency]] . Transaction: #[[transaction]]', '{\"sender\":\"Sender Name\",\"amount\":\"Received Amount\",\"currency\":\"Transfer Currency\",\"transaction\":\"Transaction Number\"}', 1, 1, 'en', NULL, NULL),
(36, 1, 'LOGIN_BONUS', 'support@binary.com', 'Login Bonus', 'Login Bonus', 'Login Commission From [[sender]] amount [[amount]] [[currency]] . Transaction: #[[transaction]]', 'Login Commission From [[sender]] amount [[amount]] [[currency]] . Transaction: #[[transaction]]', '{\"sender\":\"Sender Name\",\"amount\":\"Received Amount\",\"currency\":\"Transfer Currency\",\"transaction\":\"Transaction Number\"}', 1, 1, 'en', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `escrows`
--

CREATE TABLE `escrows` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `sender_id` bigint(20) UNSIGNED DEFAULT NULL,
  `receiver_id` bigint(20) UNSIGNED DEFAULT NULL,
  `currency_id` bigint(20) UNSIGNED DEFAULT NULL,
  `percentage` decimal(8,4) NOT NULL DEFAULT 0.0000 COMMENT 'Percent of charge',
  `charge_percentage` decimal(16,4) NOT NULL DEFAULT 0.0000 COMMENT 'After adding percent of charge',
  `charge_fixed` decimal(16,4) NOT NULL DEFAULT 0.0000,
  `charge` decimal(16,4) NOT NULL DEFAULT 0.0000,
  `amount` decimal(16,4) NOT NULL DEFAULT 0.0000,
  `transfer_amount` decimal(16,4) NOT NULL DEFAULT 0.0000 COMMENT 'Amount deduct from sender',
  `received_amount` decimal(16,4) NOT NULL DEFAULT 0.0000 COMMENT 'Amount add to receiver',
  `charge_from` tinyint(4) NOT NULL DEFAULT 0 COMMENT '0 = Sender, 1 = Receiver',
  `note` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 0 COMMENT '0=Pending, 1=generated, 2 = payment done, 3 = sender request to payment disburse, 4 = payment disbursed,5 = cancel, 6= dispute',
  `utr` char(36) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `escrows`
--

INSERT INTO `escrows` (`id`, `sender_id`, `receiver_id`, `currency_id`, `percentage`, `charge_percentage`, `charge_fixed`, `charge`, `amount`, `transfer_amount`, `received_amount`, `charge_from`, `note`, `email`, `status`, `utr`, `created_at`, `updated_at`) VALUES
(1, 1, 3, 1, '0.6000', '0.3300', '0.5000', '0.8300', '55.0000', '55.0000', '54.1700', 1, 'osman_s1986@yahoo.com osman_s1986@yahoo.com', 'osman_s1986@yahoo.com', 3, '05b0af56-358f-4620-845b-a9535698319e', '2021-02-07 04:45:09', '2021-02-08 00:14:09');

-- --------------------------------------------------------

--
-- Table structure for table `exchanges`
--

CREATE TABLE `exchanges` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `from_wallet` bigint(20) UNSIGNED DEFAULT NULL COMMENT 'Wallet table id',
  `to_wallet` bigint(20) UNSIGNED DEFAULT NULL COMMENT 'Wallet table id',
  `percentage` decimal(8,4) NOT NULL DEFAULT 0.0000 COMMENT 'Percent of charge',
  `charge_percentage` decimal(16,4) NOT NULL DEFAULT 0.0000 COMMENT 'After adding percent of charge',
  `charge_fixed` decimal(16,4) NOT NULL DEFAULT 0.0000,
  `charge` decimal(16,4) NOT NULL DEFAULT 0.0000 COMMENT 'After adding percent & fixed charge',
  `exchange_rate` decimal(16,4) NOT NULL DEFAULT 0.0000,
  `amount` decimal(16,4) NOT NULL DEFAULT 0.0000,
  `transfer_amount` decimal(16,4) NOT NULL DEFAULT 0.0000 COMMENT 'Amount deduct from exchange currency wallet',
  `received_amount` decimal(16,4) NOT NULL DEFAULT 0.0000 COMMENT 'Amount add to exchange currency wallet',
  `status` tinyint(4) NOT NULL DEFAULT 0 COMMENT '1=Success,0=Pending',
  `utr` char(36) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `exchanges`
--

INSERT INTO `exchanges` (`id`, `user_id`, `from_wallet`, `to_wallet`, `percentage`, `charge_percentage`, `charge_fixed`, `charge`, `exchange_rate`, `amount`, `transfer_amount`, `received_amount`, `status`, `utr`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 2, '2.0000', '0.2000', '1.0000', '1.2000', '84.6600', '10.0000', '11.2000', '846.6000', 1, 'c0e89ae3-95fd-4d57-ab82-83ae94e57c01', '2021-02-28 00:23:54', '2021-02-28 00:23:56'),
(2, 1, 2, 1, '1.5000', '3.7500', '1.0000', '4.7500', '0.0118', '250.0000', '254.7500', '2.9530', 1, '4145b7c0-d284-4a47-9858-646d38bc07c7', '2021-02-28 00:50:24', '2021-02-28 00:50:26');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `funds`
--

CREATE TABLE `funds` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `admin_id` bigint(20) UNSIGNED DEFAULT NULL COMMENT 'Deposit from admin',
  `currency_id` bigint(20) UNSIGNED DEFAULT NULL,
  `percentage` decimal(8,4) NOT NULL DEFAULT 0.0000 COMMENT 'Percent of charge',
  `charge_percentage` decimal(18,8) NOT NULL DEFAULT 0.00000000 COMMENT 'After adding percent of charge',
  `charge_fixed` decimal(18,8) NOT NULL DEFAULT 0.00000000,
  `charge` decimal(18,8) NOT NULL DEFAULT 0.00000000,
  `amount` decimal(18,8) NOT NULL DEFAULT 0.00000000,
  `received_amount` decimal(18,8) NOT NULL DEFAULT 0.00000000 COMMENT 'Amount add to receiver',
  `note` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 0 COMMENT '1=Success,0=Pending',
  `utr` char(36) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `funds`
--

INSERT INTO `funds` (`id`, `user_id`, `admin_id`, `currency_id`, `percentage`, `charge_percentage`, `charge_fixed`, `charge`, `amount`, `received_amount`, `note`, `email`, `status`, `utr`, `created_at`, `updated_at`) VALUES
(1, 1, NULL, 1, '0.8000', '0.08000000', '1.00000000', '1.08000000', '10.00000000', '0.00000000', NULL, 'dcrownak@gmail.com', 1, 'wmn9zBDTUDBd3o6N', '2021-01-12 04:06:13', '2021-01-12 04:06:13'),
(2, 1, NULL, 1, '0.8000', '0.08000000', '1.00000000', '1.08000000', '10.00000000', '0.00000000', NULL, 'dcrownak@gmail.com', 1, 'XgZ7kP98GN3QRf8C', '2021-01-12 04:10:51', '2021-01-12 04:10:51'),
(3, 1, NULL, 1, '1.0000', '0.10000000', '2.00000000', '2.10000000', '10.00000000', '0.00000000', NULL, 'dcrownak@gmail.com', 1, 'TIOLlH52wkoLXzf4', '2021-01-12 04:13:44', '2021-01-12 04:13:44'),
(4, 1, NULL, 1, '0.5000', '0.05000000', '1.60000000', '1.65000000', '10.00000000', '0.00000000', NULL, 'dcrownak@gmail.com', 1, 'qfSUL9XSrGm6G3cA', '2021-01-13 04:10:07', '2021-01-13 04:10:07'),
(5, 1, NULL, 1, '0.0000', '0.00000000', '0.00000000', '0.00000000', '25.00000000', '0.00000000', NULL, 'dcrownak@gmail.com', 1, '8bd0e52f-b186-43d5-be46-a54327e42f76', '2021-03-06 01:47:39', '2021-03-06 01:47:39'),
(6, 7, NULL, 1, '0.0000', '0.00000000', '0.00000000', '0.00000000', '25.00000000', '0.00000000', NULL, 'tNE2XUZWE0@gmail.com', 1, 'd418dfc9-1eb4-43a7-aceb-740588a6cc1c', '2021-03-06 02:31:27', '2021-03-06 02:31:27'),
(7, 7, NULL, 1, '0.0000', '0.00000000', '0.00000000', '0.00000000', '25.00000000', '0.00000000', NULL, 'tNE2XUZWE0@gmail.com', 1, '6448b9f7-8b72-49dc-812d-ad6b8c208474', '2021-03-06 02:31:27', '2021-03-06 02:31:27'),
(8, 7, NULL, 1, '0.0000', '0.00000000', '0.00000000', '0.00000000', '25.00000000', '0.00000000', NULL, 'tNE2XUZWE0@gmail.com', 1, '49fdf65c-f960-438a-97bb-419c10773e2f', '2021-03-06 02:31:27', '2021-03-06 02:31:27'),
(9, 7, NULL, 1, '0.0000', '0.00000000', '0.00000000', '0.00000000', '25.00000000', '0.00000000', NULL, 'tNE2XUZWE0@gmail.com', 1, '95d74418-770d-4e9e-b652-533c22a4113b', '2021-03-06 02:31:27', '2021-03-06 02:31:27'),
(10, 7, NULL, 1, '0.0000', '0.00000000', '0.00000000', '0.00000000', '25.00000000', '0.00000000', NULL, 'tNE2XUZWE0@gmail.com', 1, '262a5c72-20af-4518-b624-e3c42873aa3b', '2021-03-06 02:31:27', '2021-03-06 02:31:27'),
(17, 17, NULL, 1, '0.0000', '0.00000000', '0.00000000', '0.00000000', '25.00000000', '0.00000000', NULL, 'demouser@email.com', 1, '1e779b5e-31d1-4555-8285-5108b528fa1c', '2021-03-13 00:50:16', '2021-03-13 00:50:16');

-- --------------------------------------------------------

--
-- Table structure for table `gateways`
--

CREATE TABLE `gateways` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `code` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sort_by` int(11) DEFAULT 1,
  `image` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1 COMMENT '0: inactive, 1: active',
  `parameters` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `currencies` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `extra_parameters` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `currency` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `symbol` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `min_amount` decimal(18,8) NOT NULL,
  `max_amount` decimal(18,8) NOT NULL,
  `percentage_charge` decimal(8,4) NOT NULL DEFAULT 0.0000,
  `fixed_charge` decimal(18,8) NOT NULL DEFAULT 0.00000000,
  `convention_rate` decimal(18,8) NOT NULL DEFAULT 1.00000000,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `gateways`
--

INSERT INTO `gateways` (`id`, `code`, `name`, `sort_by`, `image`, `status`, `parameters`, `currencies`, `extra_parameters`, `currency`, `symbol`, `min_amount`, `max_amount`, `percentage_charge`, `fixed_charge`, `convention_rate`, `created_at`, `updated_at`) VALUES
(1, 'paypal', 'Paypal', 1, '5f637b5622d23.jpg', 1, '{\"cleint_id\":\"AUrvcotEVWZkksiGir6Ih4PyalQcguQgGN-7We5O1wBny3tg1w6srbQzi6GQEO8lP3yJVha2C6lyivK9\", \"secret\":\"EPx-YEgvjKDRFFu3FAsMue_iUMbMH6jHu408rHdn4iGrUCM8M12t7mX8hghUBAWwvWErBOa4Uppfp0Eh\"}', '{\"0\":{\"AUD\":\"AUD\",\"BRL\":\"BRL\",\"CAD\":\"CAD\",\"CZK\":\"CZK\",\"DKK\":\"DKK\",\"EUR\":\"EUR\",\"HKD\":\"HKD\",\"HUF\":\"HUF\",\"INR\":\"INR\",\"ILS\":\"ILS\",\"JPY\":\"JPY\",\"MYR\":\"MYR\",\"MXN\":\"MXN\",\"TWD\":\"TWD\",\"NZD\":\"NZD\",\"NOK\":\"NOK\",\"PHP\":\"PHP\",\"PLN\":\"PLN\",\"GBP\":\"GBP\",\"RUB\":\"RUB\",\"SGD\":\"SGD\",\"SEK\":\"SEK\",\"CHF\":\"CHF\",\"THB\":\"THB\",\"USD\":\"USD\"}}', NULL, 'USD', 'USD', '1.00000000', '10000.00000000', '1.0000', '0.50000000', '1.00000000', '2020-09-10 09:05:02', '2021-01-21 02:21:42'),
(2, 'stripe', 'Stripe ', 4, '5f645d432b9c0.jpg', 1, '{\"secret_key\":\"sk_test_aat3tzBCCXXBkS4sxY3M8A1B\",\"publishable_key\":\"pk_test_AU3G7doZ1sbdpJLj0NaozPBu\"}', '{\"0\":{\"USD\":\"USD\",\"AUD\":\"AUD\",\"BRL\":\"BRL\",\"CAD\":\"CAD\",\"CHF\":\"CHF\",\"DKK\":\"DKK\",\"EUR\":\"EUR\",\"GBP\":\"GBP\",\"HKD\":\"HKD\",\"INR\":\"INR\",\"JPY\":\"JPY\",\"MXN\":\"MXN\",\"MYR\":\"MYR\",\"NOK\":\"NOK\",\"NZD\":\"NZD\",\"PLN\":\"PLN\",\"SEK\":\"SEK\",\"SGD\":\"SGD\"}}', NULL, 'USD', 'USD', '1.00000000', '10000.00000000', '0.0000', '0.50000000', '1.00000000', '2020-09-10 09:05:02', '2021-01-21 02:21:42'),
(3, 'skrill', 'Skrill', 3, '5f637c7fcb9ef.jpg', 1, '{\"pay_to_email\":\"mig33@gmail.com\",\"secret_key\":\"SECRETKEY\"}', '{\"0\":{\"AED\":\"AED\",\"AUD\":\"AUD\",\"BGN\":\"BGN\",\"BHD\":\"BHD\",\"CAD\":\"CAD\",\"CHF\":\"CHF\",\"CZK\":\"CZK\",\"DKK\":\"DKK\",\"EUR\":\"EUR\",\"GBP\":\"GBP\",\"HKD\":\"HKD\",\"HRK\":\"HRK\",\"HUF\":\"HUF\",\"ILS\":\"ILS\",\"INR\":\"INR\",\"ISK\":\"ISK\",\"JOD\":\"JOD\",\"JPY\":\"JPY\",\"KRW\":\"KRW\",\"KWD\":\"KWD\",\"MAD\":\"MAD\",\"MYR\":\"MYR\",\"NOK\":\"NOK\",\"NZD\":\"NZD\",\"OMR\":\"OMR\",\"PLN\":\"PLN\",\"QAR\":\"QAR\",\"RON\":\"RON\",\"RSD\":\"RSD\",\"SAR\":\"SAR\",\"SEK\":\"SEK\",\"SGD\":\"SGD\",\"THB\":\"THB\",\"TND\":\"TND\",\"TRY\":\"TRY\",\"TWD\":\"TWD\",\"USD\":\"USD\",\"ZAR\":\"ZAR\",\"COP\":\"COP\"}}', NULL, 'USD', 'USD', '1.00000000', '10000.00000000', '0.0000', '0.50000000', '1.00000000', '2020-09-10 09:05:02', '2021-01-21 02:21:42'),
(4, 'perfectmoney', 'Perfect Money', 5, '5f64d522d8bea.jpg', 1, '{\"passphrase\":\"112233445566\",\"payee_account\":\"U26203997\"}', '{\"0\":{\"USD\":\"USD\",\"EUR\":\"EUR\"}}', NULL, 'USD', 'USD', '1.00000000', '10000.00000000', '0.0000', '0.50000000', '1.00000000', '2020-09-10 09:05:02', '2021-01-21 02:21:42'),
(5, 'paytm', 'PayTM', 7, '5f637cbfb4d4c.jpg', 1, '{\"MID\":\"uAOkSk48844590235401\",\"merchant_key\":\"pcB_oEk_R@kbm1c1\",\"WEBSITE\":\"DIYtestingweb\",\"INDUSTRY_TYPE_ID\":\"Retail\",\"CHANNEL_ID\":\"WEB\",\"transaction_url\":\"https:\\/\\/securegw.paytm.in\\/order\\/process\",\"transaction_status_url\":\"https:\\/\\/securegw.paytm.in\\/order\\/status\"}', '{\"0\":{\"AUD\":\"AUD\",\"ARS\":\"ARS\",\"BDT\":\"BDT\",\"BRL\":\"BRL\",\"BGN\":\"BGN\",\"CAD\":\"CAD\",\"CLP\":\"CLP\",\"CNY\":\"CNY\",\"COP\":\"COP\",\"HRK\":\"HRK\",\"CZK\":\"CZK\",\"DKK\":\"DKK\",\"EGP\":\"EGP\",\"EUR\":\"EUR\",\"GEL\":\"GEL\",\"GHS\":\"GHS\",\"HKD\":\"HKD\",\"HUF\":\"HUF\",\"INR\":\"INR\",\"IDR\":\"IDR\",\"ILS\":\"ILS\",\"JPY\":\"JPY\",\"KES\":\"KES\",\"MYR\":\"MYR\",\"MXN\":\"MXN\",\"MAD\":\"MAD\",\"NPR\":\"NPR\",\"NZD\":\"NZD\",\"NGN\":\"NGN\",\"NOK\":\"NOK\",\"PKR\":\"PKR\",\"PEN\":\"PEN\",\"PHP\":\"PHP\",\"PLN\":\"PLN\",\"RON\":\"RON\",\"RUB\":\"RUB\",\"SGD\":\"SGD\",\"ZAR\":\"ZAR\",\"KRW\":\"KRW\",\"LKR\":\"LKR\",\"SEK\":\"SEK\",\"CHF\":\"CHF\",\"THB\":\"THB\",\"TRY\":\"TRY\",\"UGX\":\"UGX\",\"UAH\":\"UAH\",\"AED\":\"AED\",\"GBP\":\"GBP\",\"USD\":\"USD\",\"VND\":\"VND\",\"XOF\":\"XOF\"}}', NULL, 'USD', 'USD', '1.00000000', '10000.00000000', '0.0000', '0.50000000', '1.00000000', '2020-09-10 09:05:02', '2021-01-21 02:21:42'),
(6, 'payeer', 'Payeer', 6, '5f64d52d09e13.jpg', 1, '{\"merchant_id\":\"1142293755\",\"secret_key\":\"1122334455\"}', '{\"0\":{\"USD\":\"USD\",\"EUR\":\"EUR\",\"RUB\":\"RUB\"}}', '{\"status\":\"ipn\"}', 'USD', 'USD', '1.00000000', '10000.00000000', '0.0000', '0.50000000', '1.00000000', '2020-09-10 09:05:02', '2021-01-21 02:21:42'),
(7, 'paystack', 'PayStack', 8, '5f637d069177e.jpg', 1, '{\"public_key\":\"pk_test_f922aa1a87101e3fd029e13024006862fdc0b8c7\",\"secret_key\":\"sk_test_b8d571f97c1b41d409ba339eb20b005377751dff\"}', '{\"0\":{\"USD\":\"USD\",\"NGN\":\"NGN\"}}', '{\"callback\":\"ipn\",\"webhook\":\"ipn\"}\r\n', 'NGN', 'NGN', '1.00000000', '10000.00000000', '0.0000', '0.50000000', '1.00000000', '2020-09-10 09:05:02', '2021-01-21 02:21:42'),
(8, 'voguepay', 'VoguePay', 9, '5f637d53da3e7.jpg', 1, '{\"merchant_id\":\"3242-0112543\"}', '{\"0\":{\"NGN\":\"NGN\",\"USD\":\"USD\",\"EUR\":\"EUR\",\"GBP\":\"GBP\",\"ZAR\":\"ZAR\",\"JPY\":\"JPY\",\"INR\":\"INR\",\"AUD\":\"AUD\",\"CAD\":\"CAD\",\"NZD\":\"NZD\",\"NOK\":\"NOK\",\"PLN\":\"PLN\"}}\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n', NULL, 'USD', 'USD', '1.00000000', '10000.00000000', '0.0000', '0.50000000', '1.00000000', '2020-09-10 09:05:02', '2021-01-21 02:21:42'),
(9, 'flutterwave', 'Flutterwave', 10, '5f637d6a0b22d.jpg', 1, '{\"public_key\":\"FLWPUBK_TEST-5003321b93b251536fd2e7e05232004f-X\",\"secret_key\":\"FLWSECK_TEST-d604361e2d4962f4bb2a400c5afefab1-X\",\"encryption_key\":\"FLWSECK_TEST817a365e142b\"}\r\n\r\n', '{\"0\":{\"KES\":\"KES\",\"GHS\":\"GHS\",\"NGN\":\"NGN\",\"USD\":\"USD\",\"GBP\":\"GBP\",\"EUR\":\"EUR\",\"UGX\":\"UGX\",\"TZS\":\"TZS\"}}', NULL, 'USD', 'USD', '1.00000000', '10000.00000000', '0.0000', '0.50000000', '1.00000000', '2020-09-10 09:05:02', '2021-01-21 02:21:42'),
(10, 'razorpay', 'RazorPay', 11, '5f637d80b68e0.jpg', 1, '{\"key_id\":\"rzp_test_kiOtejPbRZU90E\",\"key_secret\":\"osRDebzEqbsE1kbyQJ4y0re7\"}', '{\"0\":{\"INR\":\"INR\"}}', NULL, 'INR', 'INR', '1.00000000', '10000.00000000', '0.0000', '0.50000000', '1.00000000', '2020-09-10 09:05:02', '2021-01-21 02:21:42'),
(11, 'instamojo', 'instamojo', 12, '5f637da3c44d2.jpg', 1, '{\"api_key\":\"test_2241633c3bc44a3de84a3b33969\",\"auth_token\":\"test_279f083f7bebefd35217feef22d\",\"salt\":\"19d38908eeff4f58b2ddda2c6d86ca25\"}', '{\"0\":{\"INR\":\"INR\"}}', NULL, 'INR', 'INR', '1.00000000', '10000.00000000', '0.0000', '0.50000000', '73.51000000', '2020-09-10 09:05:02', '2021-01-21 02:21:42'),
(12, 'mollie', 'Mollie', 13, '5f637db537958.jpg', 1, '{\"api_key\":\"test_cucfwKTWfft9s337qsVfn5CC4vNkrn\"}', '{\"0\":{\"AED\":\"AED\",\"AUD\":\"AUD\",\"BGN\":\"BGN\",\"BRL\":\"BRL\",\"CAD\":\"CAD\",\"CHF\":\"CHF\",\"CZK\":\"CZK\",\"DKK\":\"DKK\",\"EUR\":\"EUR\",\"GBP\":\"GBP\",\"HKD\":\"HKD\",\"HRK\":\"HRK\",\"HUF\":\"HUF\",\"ILS\":\"ILS\",\"ISK\":\"ISK\",\"JPY\":\"JPY\",\"MXN\":\"MXN\",\"MYR\":\"MYR\",\"NOK\":\"NOK\",\"NZD\":\"NZD\",\"PHP\":\"PHP\",\"PLN\":\"PLN\",\"RON\":\"RON\",\"RUB\":\"RUB\",\"SEK\":\"SEK\",\"SGD\":\"SGD\",\"THB\":\"THB\",\"TWD\":\"TWD\",\"USD\":\"USD\",\"ZAR\":\"ZAR\"}}', NULL, 'USD', 'USD', '1.00000000', '10000.00000000', '0.0000', '0.50000000', '73.51000000', '2020-09-10 09:05:02', '2021-01-21 02:21:42'),
(13, 'twocheckout', '2checkout', 14, '5f637e7eae68b.jpg', 1, '{\"merchant_code\":\"250507228545\",\"secret_key\":\"=+0CNzfvTItqp*ygwiQE\"}', '{\"0\":{\"AFN\":\"AFN\",\"ALL\":\"ALL\",\"DZD\":\"DZD\",\"ARS\":\"ARS\",\"AUD\":\"AUD\",\"AZN\":\"AZN\",\"BSD\":\"BSD\",\"BDT\":\"BDT\",\"BBD\":\"BBD\",\"BZD\":\"BZD\",\"BMD\":\"BMD\",\"BOB\":\"BOB\",\"BWP\":\"BWP\",\"BRL\":\"BRL\",\"GBP\":\"GBP\",\"BND\":\"BND\",\"BGN\":\"BGN\",\"CAD\":\"CAD\",\"CLP\":\"CLP\",\"CNY\":\"CNY\",\"COP\":\"COP\",\"CRC\":\"CRC\",\"HRK\":\"HRK\",\"CZK\":\"CZK\",\"DKK\":\"DKK\",\"DOP\":\"DOP\",\"XCD\":\"XCD\",\"EGP\":\"EGP\",\"EUR\":\"EUR\",\"FJD\":\"FJD\",\"GTQ\":\"GTQ\",\"HKD\":\"HKD\",\"HNL\":\"HNL\",\"HUF\":\"HUF\",\"INR\":\"INR\",\"IDR\":\"IDR\",\"ILS\":\"ILS\",\"JMD\":\"JMD\",\"JPY\":\"JPY\",\"KZT\":\"KZT\",\"KES\":\"KES\",\"LAK\":\"LAK\",\"MMK\":\"MMK\",\"LBP\":\"LBP\",\"LRD\":\"LRD\",\"MOP\":\"MOP\",\"MYR\":\"MYR\",\"MVR\":\"MVR\",\"MRO\":\"MRO\",\"MUR\":\"MUR\",\"MXN\":\"MXN\",\"MAD\":\"MAD\",\"NPR\":\"NPR\",\"TWD\":\"TWD\",\"NZD\":\"NZD\",\"NIO\":\"NIO\",\"NOK\":\"NOK\",\"PKR\":\"PKR\",\"PGK\":\"PGK\",\"PEN\":\"PEN\",\"PHP\":\"PHP\",\"PLN\":\"PLN\",\"QAR\":\"QAR\",\"RON\":\"RON\",\"RUB\":\"RUB\",\"WST\":\"WST\",\"SAR\":\"SAR\",\"SCR\":\"SCR\",\"SGD\":\"SGD\",\"SBD\":\"SBD\",\"ZAR\":\"ZAR\",\"KRW\":\"KRW\",\"LKR\":\"LKR\",\"SEK\":\"SEK\",\"CHF\":\"CHF\",\"SYP\":\"SYP\",\"THB\":\"THB\",\"TOP\":\"TOP\",\"TTD\":\"TTD\",\"TRY\":\"TRY\",\"UAH\":\"UAH\",\"AED\":\"AED\",\"USD\":\"USD\",\"VUV\":\"VUV\",\"VND\":\"VND\",\"XOF\":\"XOF\",\"YER\":\"YER\"}}', '{\"approved_url\":\"ipn\"}', 'USD', 'USD', '1.00000000', '10000.00000000', '0.0000', '0.50000000', '1.00000000', '2020-09-10 09:05:02', '2021-01-21 02:21:42'),
(14, 'authorizenet', 'Authorize.Net', 15, '5f637de6d9fef.jpg', 1, '{\"login_id\":\"35s2ZJWTh2\",\"current_transaction_key\":\"3P425sHVwE8t2CzX\"}', '{\"0\":{\"AUD\":\"AUD\",\"CAD\":\"CAD\",\"CHF\":\"CHF\",\"DKK\":\"DKK\",\"EUR\":\"EUR\",\"GBP\":\"GBP\",\"NOK\":\"NOK\",\"NZD\":\"NZD\",\"PLN\":\"PLN\",\"SEK\":\"SEK\",\"USD\":\"USD\"}}', NULL, 'USD', 'USD', '1.00000000', '10000.00000000', '0.0000', '0.50000000', '1.00000000', '2020-09-10 09:05:02', '2021-01-21 02:21:42'),
(15, 'securionpay', 'SecurionPay', 16, '5f637e002d11b.jpg', 1, '{\"public_key\":\"pk_test_VZEUdaL8fYjBVbDOSkPFcgE0\",\"secret_key\":\"sk_test_yd5JJnYpsEoKtlaXDBkAFpse\"}', '{\"0\":{\"AFN\":\"AFN\", \"DZD\":\"DZD\", \"ARS\":\"ARS\", \"AUD\":\"AUD\", \"BHD\":\"BHD\", \"BDT\":\"BDT\", \"BYR\":\"BYR\", \"BAM\":\"BAM\", \"BWP\":\"BWP\", \"BRL\":\"BRL\", \"BND\":\"BND\", \"BGN\":\"BGN\", \"CAD\":\"CAD\", \"CLP\":\"CLP\", \"CNY\":\"CNY\", \"COP\":\"COP\", \"KMF\":\"KMF\", \"HRK\":\"HRK\", \"CZK\":\"CZK\", \"DKK\":\"DKK\", \"DJF\":\"DJF\", \"DOP\":\"DOP\", \"EGP\":\"EGP\", \"ETB\":\"ETB\", \"ERN\":\"ERN\", \"EUR\":\"EUR\", \"GEL\":\"GEL\", \"HKD\":\"HKD\", \"HUF\":\"HUF\", \"ISK\":\"ISK\", \"INR\":\"INR\", \"IDR\":\"IDR\", \"IRR\":\"IRR\", \"IQD\":\"IQD\", \"ILS\":\"ILS\", \"JMD\":\"JMD\", \"JPY\":\"JPY\", \"JOD\":\"JOD\", \"KZT\":\"KZT\", \"KES\":\"KES\", \"KWD\":\"KWD\", \"KGS\":\"KGS\", \"LVL\":\"LVL\", \"LBP\":\"LBP\", \"LTL\":\"LTL\", \"MOP\":\"MOP\", \"MKD\":\"MKD\", \"MGA\":\"MGA\", \"MWK\":\"MWK\", \"MYR\":\"MYR\", \"MUR\":\"MUR\", \"MXN\":\"MXN\", \"MDL\":\"MDL\", \"MAD\":\"MAD\", \"MZN\":\"MZN\", \"NAD\":\"NAD\", \"NPR\":\"NPR\", \"ANG\":\"ANG\", \"NZD\":\"NZD\", \"NOK\":\"NOK\", \"OMR\":\"OMR\", \"PKR\":\"PKR\", \"PEN\":\"PEN\", \"PHP\":\"PHP\", \"PLN\":\"PLN\", \"QAR\":\"QAR\", \"RON\":\"RON\", \"RUB\":\"RUB\", \"SAR\":\"SAR\", \"RSD\":\"RSD\", \"SGD\":\"SGD\", \"ZAR\":\"ZAR\", \"KRW\":\"KRW\", \"IKR\":\"IKR\", \"LKR\":\"LKR\", \"SEK\":\"SEK\", \"CHF\":\"CHF\", \"SYP\":\"SYP\", \"TWD\":\"TWD\", \"TZS\":\"TZS\", \"THB\":\"THB\", \"TND\":\"TND\", \"TRY\":\"TRY\", \"UAH\":\"UAH\", \"AED\":\"AED\", \"GBP\":\"GBP\", \"USD\":\"USD\", \"VEB\":\"VEB\", \"VEF\":\"VEF\", \"VND\":\"VND\", \"XOF\":\"XOF\", \"YER\":\"YER\", \"ZMK\":\"ZMK\"}}', NULL, 'USD', 'USD', '1.00000000', '10000.00000000', '0.0000', '0.50000000', '1.00000000', '2020-09-10 09:05:02', '2021-01-21 02:21:42'),
(16, 'payumoney', 'PayUmoney', 17, '5f6390dbaa6ff.jpg', 1, '{\"merchant_key\":\"gtKFFx\",\"salt\":\"eCwWELxi\"}', '{\"0\":{\"INR\":\"INR\"}}', NULL, 'INR', 'INR', '1.00000000', '10000.00000000', '0.0000', '0.50000000', '73.51000000', '2020-09-10 09:05:02', '2021-01-21 02:21:42'),
(17, 'mercadopago', 'Mercado Pago', 18, '5f645d1bc1f24.jpg', 1, '{\"access_token\":\"TEST-705032440135962-041006-ad2e021853f22338fe1a4db9f64d1491-421886156\"}', '{\"0\":{\"ARS\":\"ARS\",\"BOB\":\"BOB\",\"BRL\":\"BRL\",\"CLF\":\"CLF\",\"CLP\":\"CLP\",\"COP\":\"COP\",\"CRC\":\"CRC\",\"CUC\":\"CUC\",\"CUP\":\"CUP\",\"DOP\":\"DOP\",\"EUR\":\"EUR\",\"GTQ\":\"GTQ\",\"HNL\":\"HNL\",\"MXN\":\"MXN\",\"NIO\":\"NIO\",\"PAB\":\"PAB\",\"PEN\":\"PEN\",\"PYG\":\"PYG\",\"USD\":\"USD\",\"UYU\":\"UYU\",\"VEF\":\"VEF\",\"VES\":\"VES\"}}', NULL, 'BRL', 'BRL', '3715.12000000', '371500000.12000000', '0.0000', '0.50000000', '3715.12000000', '2020-09-10 09:05:02', '2021-01-21 02:21:42'),
(18, 'coingate', 'Coingate', 21, '5f659e5355859.jpg', 1, '{\"api_key\":\"Ba1VgPx6d437xLXGKCBkmwVCEw5kHzRJ6thbGo-N\"}', '{\"0\":{\"USD\":\"USD\",\"EUR\":\"EUR\"}}', NULL, 'USD', 'USD', '1.00000000', '10000.00000000', '0.0000', '0.50000000', '1.00000000', '2020-09-10 09:05:02', '2021-01-21 02:21:42'),
(19, 'coinbasecommerce', 'Coinbase Commerce', 22, '5f6703145a5ca.jpg', 1, '{\"api_key\":\"c71152b8-ab4e-4712-a421-c5c7ea5165a2\",\"secret\":\"a709d081-e693-46e0-8a34-61fd785b20b3\"}', '{\"0\":{\"AED\":\"AED\",\"AFN\":\"AFN\",\"ALL\":\"ALL\",\"AMD\":\"AMD\",\"ANG\":\"ANG\",\"AOA\":\"AOA\",\"ARS\":\"ARS\",\"AUD\":\"AUD\",\"AWG\":\"AWG\",\"AZN\":\"AZN\",\"BAM\":\"BAM\",\"BBD\":\"BBD\",\"BDT\":\"BDT\",\"BGN\":\"BGN\",\"BHD\":\"BHD\",\"BIF\":\"BIF\",\"BMD\":\"BMD\",\"BND\":\"BND\",\"BOB\":\"BOB\",\"BRL\":\"BRL\",\"BSD\":\"BSD\",\"BTN\":\"BTN\",\"BWP\":\"BWP\",\"BYN\":\"BYN\",\"BZD\":\"BZD\",\"CAD\":\"CAD\",\"CDF\":\"CDF\",\"CHF\":\"CHF\",\"CLF\":\"CLF\",\"CLP\":\"CLP\",\"CNY\":\"CNY\",\"COP\":\"COP\",\"CRC\":\"CRC\",\"CUC\":\"CUC\",\"CUP\":\"CUP\",\"CVE\":\"CVE\",\"CZK\":\"CZK\",\"DJF\":\"DJF\",\"DKK\":\"DKK\",\"DOP\":\"DOP\",\"DZD\":\"DZD\",\"EGP\":\"EGP\",\"ERN\":\"ERN\",\"ETB\":\"ETB\",\"EUR\":\"EUR\",\"FJD\":\"FJD\",\"FKP\":\"FKP\",\"GBP\":\"GBP\",\"GEL\":\"GEL\",\"GGP\":\"GGP\",\"GHS\":\"GHS\",\"GIP\":\"GIP\",\"GMD\":\"GMD\",\"GNF\":\"GNF\",\"GTQ\":\"GTQ\",\"GYD\":\"GYD\",\"HKD\":\"HKD\",\"HNL\":\"HNL\",\"HRK\":\"HRK\",\"HTG\":\"HTG\",\"HUF\":\"HUF\",\"IDR\":\"IDR\",\"ILS\":\"ILS\",\"IMP\":\"IMP\",\"INR\":\"INR\",\"IQD\":\"IQD\",\"IRR\":\"IRR\",\"ISK\":\"ISK\",\"JEP\":\"JEP\",\"JMD\":\"JMD\",\"JOD\":\"JOD\",\"JPY\":\"JPY\",\"KES\":\"KES\",\"KGS\":\"KGS\",\"KHR\":\"KHR\",\"KMF\":\"KMF\",\"KPW\":\"KPW\",\"KRW\":\"KRW\",\"KWD\":\"KWD\",\"KYD\":\"KYD\",\"KZT\":\"KZT\",\"LAK\":\"LAK\",\"LBP\":\"LBP\",\"LKR\":\"LKR\",\"LRD\":\"LRD\",\"LSL\":\"LSL\",\"LYD\":\"LYD\",\"MAD\":\"MAD\",\"MDL\":\"MDL\",\"MGA\":\"MGA\",\"MKD\":\"MKD\",\"MMK\":\"MMK\",\"MNT\":\"MNT\",\"MOP\":\"MOP\",\"MRO\":\"MRO\",\"MUR\":\"MUR\",\"MVR\":\"MVR\",\"MWK\":\"MWK\",\"MXN\":\"MXN\",\"MYR\":\"MYR\",\"MZN\":\"MZN\",\"NAD\":\"NAD\",\"NGN\":\"NGN\",\"NIO\":\"NIO\",\"NOK\":\"NOK\",\"NPR\":\"NPR\",\"NZD\":\"NZD\",\"OMR\":\"OMR\",\"PAB\":\"PAB\",\"PEN\":\"PEN\",\"PGK\":\"PGK\",\"PHP\":\"PHP\",\"PKR\":\"PKR\",\"PLN\":\"PLN\",\"PYG\":\"PYG\",\"QAR\":\"QAR\",\"RON\":\"RON\",\"RSD\":\"RSD\",\"RUB\":\"RUB\",\"RWF\":\"RWF\",\"SAR\":\"SAR\",\"SBD\":\"SBD\",\"SCR\":\"SCR\",\"SDG\":\"SDG\",\"SEK\":\"SEK\",\"SGD\":\"SGD\",\"SHP\":\"SHP\",\"SLL\":\"SLL\",\"SOS\":\"SOS\",\"SRD\":\"SRD\",\"SSP\":\"SSP\",\"STD\":\"STD\",\"SVC\":\"SVC\",\"SYP\":\"SYP\",\"SZL\":\"SZL\",\"THB\":\"THB\",\"TJS\":\"TJS\",\"TMT\":\"TMT\",\"TND\":\"TND\",\"TOP\":\"TOP\",\"TRY\":\"TRY\",\"TTD\":\"TTD\",\"TWD\":\"TWD\",\"TZS\":\"TZS\",\"UAH\":\"UAH\",\"UGX\":\"UGX\",\"USD\":\"USD\",\"UYU\":\"UYU\",\"UZS\":\"UZS\",\"VEF\":\"VEF\",\"VND\":\"VND\",\"VUV\":\"VUV\",\"WST\":\"WST\",\"XAF\":\"XAF\",\"XAG\":\"XAG\",\"XAU\":\"XAU\",\"XCD\":\"XCD\",\"XDR\":\"XDR\",\"XOF\":\"XOF\",\"XPD\":\"XPD\",\"XPF\":\"XPF\",\"XPT\":\"XPT\",\"YER\":\"YER\",\"ZAR\":\"ZAR\",\"ZMW\":\"ZMW\",\"ZWL\":\"ZWL\"}}', NULL, 'USD', 'USD', '1.00000000', '10000.00000000', '0.0000', '0.50000000', '1.00000000', '2020-09-10 09:05:02', '2021-01-21 02:21:42'),
(20, 'monnify', 'Monnify', 19, '5fbca5d05057f.jpg', 1, '{\"api_key\":\"MK_TEST_LB5KJDYD65\",\"secret_key\":\"WM9B4GSW826XRCNABM3NF92K9957CVMU\", \"contract_code\":\"5566252118\"}', '{\"0\":{\"NGN\":\"NGN\"}}', NULL, 'NGN', 'NGN', '1.00000000', '10000.00000000', '0.0000', '0.50000000', '1.00000000', '2020-09-10 09:05:02', '2021-01-21 02:21:42'),
(21, 'blockio', 'Block.io', 23, '5fe038332ad52.jpg', 1, '{\"api_key\":\"1d97-a9af-6521-a330\",\"api_pin\":\"654abc654opp\"}', '{\"1\":{\"BTC\":\"BTC\",\"LTC\":\"LTC\",\"DOGE\":\"DOGE\"}}', '{\"cron\":\"ipn\"}', 'BTC', 'BTC', '0.00004200', '10000.00000000', '0.0000', '0.50000000', '0.00004200', '2020-09-10 09:05:02', '2021-01-21 02:21:42'),
(22, 'coinpayments', 'CoinPayments', 20, '5fe430ece62d5.jpg', 1, '{\"merchant_id\":\"93a1e014c4ad60a7980b4a7239673cb4\"}', '{\"0\":{\"USD\":\"USD\",\"AUD\":\"AUD\",\"BRL\":\"BRL\",\"CAD\":\"CAD\",\"CHF\":\"CHF\",\"CLP\":\"CLP\",\"CNY\":\"CNY\",\"DKK\":\"DKK\",\"EUR\":\"EUR\",\"GBP\":\"GBP\",\"HKD\":\"HKD\",\"INR\":\"INR\",\"ISK\":\"ISK\",\"JPY\":\"JPY\",\"KRW\":\"KRW\",\"NZD\":\"NZD\",\"PLN\":\"PLN\",\"RUB\":\"RUB\",\"SEK\":\"SEK\",\"SGD\":\"SGD\",\"THB\":\"THB\",\"TWD\":\"TWD\"},\"1\":{\"BTC\":\"Bitcoin\",\"BTC.LN\":\"Bitcoin (Lightning Network)\",\"LTC\":\"Litecoin\",\"CPS\":\"CPS Coin\",\"VLX\":\"Velas\",\"APL\":\"Apollo\",\"AYA\":\"Aryacoin\",\"BAD\":\"Badcoin\",\"BCD\":\"Bitcoin Diamond\",\"BCH\":\"Bitcoin Cash\",\"BCN\":\"Bytecoin\",\"BEAM\":\"BEAM\",\"BITB\":\"Bean Cash\",\"BLK\":\"BlackCoin\",\"BSV\":\"Bitcoin SV\",\"BTAD\":\"Bitcoin Adult\",\"BTG\":\"Bitcoin Gold\",\"BTT\":\"BitTorrent\",\"CLOAK\":\"CloakCoin\",\"CLUB\":\"ClubCoin\",\"CRW\":\"Crown\",\"CRYP\":\"CrypticCoin\",\"CRYT\":\"CryTrExCoin\",\"CURE\":\"CureCoin\",\"DASH\":\"DASH\",\"DCR\":\"Decred\",\"DEV\":\"DeviantCoin\",\"DGB\":\"DigiByte\",\"DOGE\":\"Dogecoin\",\"EBST\":\"eBoost\",\"EOS\":\"EOS\",\"ETC\":\"Ether Classic\",\"ETH\":\"Ethereum\",\"ETN\":\"Electroneum\",\"EUNO\":\"EUNO\",\"EXP\":\"EXP\",\"Expanse\":\"Expanse\",\"FLASH\":\"FLASH\",\"GAME\":\"GameCredits\",\"GLC\":\"Goldcoin\",\"GRS\":\"Groestlcoin\",\"KMD\":\"Komodo\",\"LOKI\":\"LOKI\",\"LSK\":\"LSK\",\"MAID\":\"MaidSafeCoin\",\"MUE\":\"MonetaryUnit\",\"NAV\":\"NAV Coin\",\"NEO\":\"NEO\",\"NMC\":\"Namecoin\",\"NVST\":\"NVO Token\",\"NXT\":\"NXT\",\"OMNI\":\"OMNI\",\"PINK\":\"PinkCoin\",\"PIVX\":\"PIVX\",\"POT\":\"PotCoin\",\"PPC\":\"Peercoin\",\"PROC\":\"ProCurrency\",\"PURA\":\"PURA\",\"QTUM\":\"QTUM\",\"RES\":\"Resistance\",\"RVN\":\"Ravencoin\",\"RVR\":\"RevolutionVR\",\"SBD\":\"Steem Dollars\",\"SMART\":\"SmartCash\",\"SOXAX\":\"SOXAX\",\"STEEM\":\"STEEM\",\"STRAT\":\"STRAT\",\"SYS\":\"Syscoin\",\"TPAY\":\"TokenPay\",\"TRIGGERS\":\"Triggers\",\"TRX\":\" TRON\",\"UBQ\":\"Ubiq\",\"UNIT\":\"UniversalCurrency\",\"USDT\":\"Tether USD (Omni Layer)\",\"VTC\":\"Vertcoin\",\"WAVES\":\"Waves\",\"XCP\":\"Counterparty\",\"XEM\":\"NEM\",\"XMR\":\"Monero\",\"XSN\":\"Stakenet\",\"XSR\":\"SucreCoin\",\"XVG\":\"VERGE\",\"XZC\":\"ZCoin\",\"ZEC\":\"ZCash\",\"ZEN\":\"Horizen\"}}', NULL, 'BTC', 'BTC', '0.00004200', '10000.00000000', '0.0000', '0.50000000', '0.00004200', '2020-09-10 09:05:02', '2021-01-21 02:21:42'),
(23, 'blockchain', 'Blockchain', 24, '5fe439f477bb7.jpg', 1, '{\"api_key\":\"8df2e5a0-3798-4b74-871d-973615b57e7b\",\"xpub_code\":\"xpub6CXLqfWXj1xgXe79nEQb3pv2E7TGD13pZgHceZKrQAxqXdrC2FaKuQhm5CYVGyNcHLhSdWau4eQvq3EDCyayvbKJvXa11MX9i2cHPugpt3G\"}', '{\"1\":{\"BTC\":\"BTC\"}}', NULL, 'BTC', 'BTC', '0.00000000', '10000.00000000', '0.0000', '0.50000000', '0.00000000', '2020-09-10 09:05:02', '2021-01-21 02:21:42'),
(25, 'cashmaal', 'cashmaal', 2, '5ffffeed4b5241610612461.jpg', 1, '{\"web_id\": \"3748\",\"ipn_key\": \"546254628759524554647987\"}', '{\"0\":{\"PKR\":\"PKR\",\"USD\":\"USD\"}}', '{\"ipn_url\":\"ipn\"}', 'PKR', 'PKR', '1.00000000', '100.00000000', '0.0000', '0.00000000', '1.00000000', NULL, '2021-01-21 02:21:42');

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `languages`
--

CREATE TABLE `languages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `short_name` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `flag` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_active` tinyint(4) NOT NULL DEFAULT 1 COMMENT '1 = active, 0 = inactive',
  `rtl` tinyint(4) NOT NULL DEFAULT 0 COMMENT '1 = active, 0 = inactive	',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `languages`
--

INSERT INTO `languages` (`id`, `name`, `short_name`, `flag`, `is_active`, `rtl`, `created_at`, `updated_at`) VALUES
(1, 'English', 'en', 'us.png', 1, 0, '2021-01-20 04:49:29', '2021-01-20 05:09:37'),
(2, 'Spanish', 'es', 'es.jpg', 1, 0, '2021-01-21 05:33:06', '2021-02-13 01:15:16'),
(3, 'French', 'fr', 'fr.png', 1, 0, '2021-01-27 05:52:46', '2021-02-13 01:15:28');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2020_10_19_061600_create_basic_controls_table', 1),
(5, '2020_10_20_100935_create_email_controls_table', 1),
(6, '2020_10_24_072526_create_email_templates_table', 1),
(7, '2020_11_07_085217_create_currencies_table', 2),
(8, '2020_11_08_075435_create_charges_limits_table', 3),
(9, '2020_11_09_112425_create_transfers_table', 4),
(10, '2020_11_11_103026_create_wallets_table', 5),
(11, '2020_11_14_065358_create_security_questions_table', 6),
(12, '2020_11_14_085811_create_two_factor_settings_table', 7),
(13, '2020_11_16_074706_create_transactions_table', 8),
(14, '2020_11_16_132223_create_jobs_table', 9),
(15, '2020_11_18_063222_create_exchanges_table', 10),
(16, '2020_11_19_072459_create_request_money_table', 11),
(17, '2020_11_25_060330_create_user_profiles_table', 12),
(18, '2020_11_30_095703_create_redeem_codes_table', 13),
(19, '2020_12_03_103512_create_admins_table', 14),
(20, '2020_12_06_100331_create_escrows_table', 15),
(21, '2020_12_09_064344_create_vouchers_table', 16),
(22, '2020_12_12_112328_create_sms_controls_table', 17),
(23, '2020_12_20_090105_create_sms_templates_table', 18),
(25, '2020_12_24_051324_create_payout_methods_table', 19),
(26, '2020_12_24_081403_create_payouts_table', 20),
(27, '2020_12_31_063516_create_site_notifications_table', 21),
(56, '2021_01_10_080449_create_deposits_table', 22),
(57, '2021_01_12_071930_create_funds_table', 23),
(58, '2021_01_16_121411_create_admin_profiles_table', 24),
(72, '2021_01_16_131037_create_disputes_table', 25),
(73, '2021_01_16_132315_create_dispute_details_table', 25),
(74, '2021_01_20_095223_create_languages_table', 26),
(75, '2021_01_21_101929_create_templates_table', 27),
(76, '2021_01_24_063900_create_template_media_table', 28),
(80, '2021_01_26_122022_create_contents_table', 29),
(81, '2021_01_26_122211_create_content_details_table', 29),
(82, '2021_01_26_122228_create_content_media_table', 29),
(84, '2021_01_31_060855_create_contacts_table', 30),
(85, '2021_01_31_074126_create_subscribes_table', 31),
(86, '2021_03_08_060607_create_referral_bonuses_table', 32),
(87, '2021_03_08_072720_create_commission_entries_table', 33),
(89, '2021_03_15_042634_create_basic_controls_table', 34);

-- --------------------------------------------------------

--
-- Table structure for table `notify_templates`
--

CREATE TABLE `notify_templates` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `language_id` bigint(20) UNSIGNED DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `template_key` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `body` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `short_keys` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `notify_for` tinyint(1) NOT NULL DEFAULT 0 COMMENT '1=> Admin, 0=> User',
  `lang_code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `notify_templates`
--

INSERT INTO `notify_templates` (`id`, `language_id`, `name`, `template_key`, `body`, `short_keys`, `status`, `notify_for`, `lang_code`, `created_at`, `updated_at`) VALUES
(1, 1, 'Send money', 'TRANSFER_TO', '[[sender]] send money to your account amount [[amount]] [[currency]] . Transaction: #[[transaction]]', '{\"sender\":\"Sender Name\",\"amount\":\"Received Amount\",\"currency\":\"Transfer Currency\",\"transaction\":\"Transaction Number\"}', 1, 0, 'en', NULL, NULL),
(2, 1, 'Send money', 'TRANSFER_FROM', 'You have send money to [[receiver]] account amount [[amount]] [[currency]].Transaction: #[[transaction]]', '{\"receiver\":\"Receiver Name\",\"amount\":\"Send Amount\",\"currency\":\"Transfer Currency\",\"transaction\":\"Transaction Number\"}', 1, 0, 'en', NULL, NULL),
(3, 1, 'Request Money Initialise', 'REQUEST_MONEY_INIT', '[[sender]] request for send money to account amount [[amount]] [[currency]] . Transaction: #[[transaction]]', '{\"sender\":\"Sender Name\",\"amount\":\"Received Amount\",\"currency\":\"Transfer Currency\",\"transaction\":\"Transaction Number\"}', 1, 0, 'en', NULL, NULL),
(4, 1, 'Request Money Confirm', 'REQUEST_MONEY_CONFIRM', '[[sender]] confirm your request money amount [[amount]] [[currency]] . Transaction: #[[transaction]]', '{\"sender\":\"Sender Name\",\"amount\":\"Received Amount\",\"currency\":\"Transfer Currency\",\"transaction\":\"Transaction Number\"}', 1, 0, 'en', NULL, NULL),
(5, 1, 'Request Money Cancel', 'REQUEST_MONEY_CANCEL', '[[sender]] cancel your request money amount [[amount]] [[currency]] . Transaction: #[[transaction]]', '{\"sender\":\"Sender Name\",\"amount\":\"Received Amount\",\"currency\":\"Transfer Currency\",\"transaction\":\"Transaction Number\"}', 1, 0, 'en', NULL, NULL),
(6, 1, 'Money Exchange', 'MONEY_EXCHANGE', 'You are exchange [[from_amount]] [[from_currency]] to [[to_amount]] [[to_currency]]. Transaction: #[[transaction]]', '{\"from_amount\":\"Amount Exchange From\",\"from_currency\":\"Currency Exchange From\",\"to_amount\":\"Amount Exchange To\",\"to_currency\":\"Currency Exchange To\",\"transaction\":\"Transaction Number\"}', 1, 0, 'en', NULL, NULL),
(7, 1, 'Redeem Code Generate', 'REDEEM_CODE_GENERATE', 'You have generate a redeem code amount [[amount]] [[currency]].Transaction: #[[transaction]]', '{\"amount\":\"Request Amount\",\"currency\":\"Request Currency\",\"transaction\":\"Redeem Code\"}', 1, 0, 'en', NULL, NULL),
(8, 1, 'Redeem code sender', 'REDEEM_CODE_SENDER', '[[receiver]] used your redeem code amount [[amount]] [[currency]] . Transaction: #[[transaction]]', '{\"receiver\":\"Receiver Name who used code\",\"amount\":\"Request Amount\",\"currency\":\"Request Currency\",\"transaction\":\"Transaction Number\"}', 1, 0, 'en', NULL, NULL),
(9, 1, 'Redeem code used by', 'REDEEM_CODE_USED_BY', 'You have used a redeem code amount [[amount]] [[currency]] . Transaction: #[[transaction]]', '{\"amount\":\"Request Amount\",\"currency\":\"Request Currency\",\"transaction\":\"Redeem Code\"}', 1, 0, 'en', NULL, NULL),
(10, 1, 'Escrow request sender', 'ESCROW_REQUEST_SENDER', 'Your escrow request to [[receiver]] amount [[amount]] [[currency]] . Transaction: #[[transaction]]', '{\"receiver\":\"Receiver Name\",\"amount\":\"Request Amount\",\"currency\":\"Request Currency\",\"transaction\":\"Transaction Number\"}', 1, 0, 'en', NULL, NULL),
(11, 1, 'Escrow request receiver', 'ESCROW_REQUEST_RECEIVER', 'You have escrow request from [[sender]] amount [[amount]] [[currency]] . Transaction: #[[transaction]]', '{\"sender\":\"Sender Name\",\"amount\":\"Request Amount\",\"currency\":\"Request Currency\",\"transaction\":\"Transaction Number\"}', 1, 0, 'en', NULL, NULL),
(12, 1, 'Escrow Request Accept from', 'ESCROW_REQUEST_ACCEPT_FROM', '[[sender]] accept your request amount [[amount]] [[currency]] . Transaction: #[[transaction]]', '{\"sender\":\"Request sender Name\",\"amount\":\"Received Amount\",\"currency\":\"Transfer Currency\",\"transaction\":\"Transaction Number\"}', 1, 0, 'en', NULL, NULL),
(13, 1, 'Escrow Request Accept by', 'ESCROW_REQUEST_ACCEPT_BY', 'You accept escrow request amount [[amount]] [[currency]] . Transaction: #[[transaction]]', '{\"amount\":\"Received Amount\",\"currency\":\"Transfer Currency\",\"transaction\":\"Transaction Number\"}', 1, 0, 'en', NULL, NULL),
(14, 1, 'Escrow Request Cancel from', 'ESCROW_REQUEST_CANCEL_FROM', '[[sender]] Cancel your request amount [[amount]] [[currency]] . Transaction: #[[transaction]]', '{\"sender\":\"Request sender Name\",\"amount\":\"Received Amount\",\"currency\":\"Transfer Currency\",\"transaction\":\"Transaction Number\"}', 1, 0, 'en', NULL, NULL),
(15, 1, 'Escrow Request Cancel by', 'ESCROW_REQUEST_CANCEL_BY', 'You Cancel escrow request amount [[amount]] [[currency]] . Transaction: #[[transaction]]', '{\"amount\":\"Received Amount\",\"currency\":\"Transfer Currency\",\"transaction\":\"Transaction Number\"}', 1, 0, 'en', NULL, NULL),
(16, 1, 'Escrow payment disburse from', 'ESCROW_PAYMENT_DISBURSED_REQUEST_FROM', '[[sender]] request to disburse your amount [[amount]] [[currency]] . Transaction: #[[transaction]]', '{\"sender\":\"Request sender Name\",\"amount\":\"Request Amount\",\"currency\":\"Request Currency\",\"transaction\":\"Transaction Number\"}', 1, 0, 'en', NULL, NULL),
(17, 1, 'request to payment disburse by', 'ESCROW_PAYMENT_DISBURSED_REQUEST_BY', 'You request escrow disburse amount [[amount]] [[currency]] . Transaction: #[[transaction]]', '{\"amount\":\"Request Amount\",\"currency\":\"Request Currency\",\"transaction\":\"Transaction Number\"}', 1, 0, 'en', NULL, NULL),
(18, 1, 'Escrow payment disburse from', 'ESCROW_PAYMENT_DISBURSED_FROM', '[[sender]] disburse your request amount [[amount]] [[currency]] . Transaction: #[[transaction]]', '{\"sender\":\"Request sender Name\",\"amount\":\"Request Amount\",\"currency\":\"Request Currency\",\"transaction\":\"Transaction Number\"}', 1, 0, 'en', NULL, NULL),
(19, 1, 'request to payment disburse by', 'ESCROW_PAYMENT_DISBURSED_BY', 'You disburse escrow request amount [[amount]] [[currency]] . Transaction: #[[transaction]]', '{\"amount\":\"Request Amount\",\"currency\":\"Request Currency\",\"transaction\":\"Transaction Number\"}', 1, 0, 'en', NULL, NULL),
(20, 1, 'Dispute request to admin', 'DISPUTE_REQUEST_TO_ADMIN', '[[sender]] dispute escrow request amount [[amount]] [[currency]] . Transaction: #[[transaction]] click to reply [[link]]', '{\"sender\":\"Sender Name\",\"amount\":\"Request Amount\",\"currency\":\"Request Currency\",\"transaction\":\"Transaction Number\",\"link\":\"Dispute reply link\"}', 1, 1, 'en', NULL, NULL),
(21, 1, 'Dispute request to user', 'DISPUTE_REQUEST_TO_USER', '[[sender]] reply dispute escrow request amount. Transaction: #[[transaction]] click to reply [[link]]', '{\"sender\":\"Sender Name\",\"transaction\":\"Transaction Number\",\"link\":\"Dispute reply link\"}', 1, 0, 'en', NULL, NULL),
(22, 1, 'Voucher payment request to', 'VOUCHER_PAYMENT_REQUEST_TO', '[[sender]] request to voucher payment amount [[amount]] [[currency]] . Transaction: #[[transaction]] click to payment [[link]]', '{\"sender\":\"Sender Name\",\"amount\":\"Request Amount\",\"currency\":\"Request Currency\",\"transaction\":\"Transaction Number\",\"link\":\"Dispute reply link\"}', 1, 0, 'en', NULL, NULL),
(23, 1, 'Voucher payment request from', 'VOUCHER_PAYMENT_REQUEST_FROM', 'You request to [[receiver]] voucher payment amount [[amount]] [[currency]] . Transaction: #[[transaction]]', '{\"receiver\":\"Receiver Name\",\"amount\":\"Request Amount\",\"currency\":\"Request Currency\",\"transaction\":\"Transaction Number\"}', 1, 0, 'en', NULL, NULL),
(24, 1, 'Voucher payment to', 'VOUCHER_PAYMENT_TO', '[[receiver]] payment to your voucher amount [[amount]] [[currency]] . Transaction: #[[transaction]]', '{\"receiver\":\"Request receiver name\",\"amount\":\"Request Amount\",\"currency\":\"Request Currency\",\"transaction\":\"Transaction Number\"}', 1, 0, 'en', NULL, NULL),
(25, 1, 'Voucher payment from', 'VOUCHER_PAYMENT_FROM', 'You payment to [[sender]] voucher amount [[amount]] [[currency]] . Transaction: #[[transaction]]', '{\"sender\":\"Request sender Name\",\"amount\":\"Request Amount\",\"currency\":\"Request Currency\",\"transaction\":\"Transaction Number\"}', 1, 0, 'en', NULL, NULL),
(26, 1, 'Voucher payment cancel to', 'VOUCHER_PAYMENT_CANCEL_TO', '[[receiver]] payment cancel to your voucher amount [[amount]] [[currency]] . Transaction: #[[transaction]]', '{\"receiver\":\"Request receiver name\",\"amount\":\"Request Amount\",\"currency\":\"Request Currency\",\"transaction\":\"Transaction Number\"}', 1, 0, 'en', NULL, NULL),
(27, 1, 'Voucher payment cancel from', 'VOUCHER_PAYMENT_CANCEL_FROM', 'You payment cancel to [[sender]] voucher amount [[amount]] [[currency]] . Transaction: #[[transaction]]', '{\"sender\":\"Request sender Name\",\"amount\":\"Request Amount\",\"currency\":\"Request Currency\",\"transaction\":\"Transaction Number\"}', 1, 0, 'en', NULL, NULL),
(28, 1, 'Payout Request Admin', 'PAYOUT_REQUEST_TO_ADMIN', '[[sender]] request for payment amount [[amount]] [[currency]] . Transaction: #[[transaction]]', '{\"sender\":\"Sender Name\",\"amount\":\"Received Amount\",\"currency\":\"Transfer Currency\",\"transaction\":\"Transaction Number\"}', 1, 1, 'en', NULL, NULL),
(29, 1, 'Payout Request from', 'PAYOUT_REQUEST_FROM', 'You request for payout amount [[amount]] [[currency]] . Transaction: #[[transaction]]', '{\"amount\":\"Received Amount\",\"currency\":\"Transfer Currency\",\"transaction\":\"Transaction Number\"}', 1, 0, 'en', NULL, NULL),
(30, 1, 'Payout Confirm', 'PAYOUT_CONFIRM', '[[sender]] confirm your payout amount [[amount]] [[currency]] . Transaction: #[[transaction]]', '{\"sender\":\"Sender Name\",\"amount\":\"Received Amount\",\"currency\":\"Transfer Currency\",\"transaction\":\"Transaction Number\"}', 1, 0, 'en', NULL, NULL),
(31, 1, 'Payout Cancel', 'PAYOUT_CANCEL', '[[sender]] cancel your payout amount [[amount]] [[currency]] . Transaction: #[[transaction]]', '{\"sender\":\"Sender Name\",\"amount\":\"Received Amount\",\"currency\":\"Transfer Currency\",\"transaction\":\"Transaction Number\"}', 1, 0, 'en', NULL, NULL),
(32, 1, 'Add Fund user user', 'ADD_FUND_USER_USER', 'you add fund money amount [[amount]] [[currency]] . Transaction: #[[transaction]]', '{\"amount\":\"Request Amount\",\"currency\":\"Request Currency\",\"transaction\":\"Transaction Number\"}', 1, 0, 'en', NULL, NULL),
(33, 1, 'Add Fund user admin', 'ADD_FUND_USER_ADMIN', '[[user]] add fund money amount [[amount]] [[currency]] . Transaction: #[[transaction]]', '{\"user\":\"User full name\",\"amount\":\"Request Amount\",\"currency\":\"Request Currency\",\"transaction\":\"Transaction Number\"}', 1, 1, 'en', NULL, NULL),
(34, 1, 'Deposit Bonus', 'DEPOSIT_BONUS', 'Deposit Commission From [[sender]] amount [[amount]] [[currency]] . Transaction: #[[transaction]]', '{\"sender\":\"Sender Name\",\"amount\":\"Received Amount\",\"currency\":\"Transfer Currency\",\"transaction\":\"Transaction Number\"}', 1, 0, 'en', NULL, NULL),
(35, 1, 'Login Bonus', 'LOGIN_BONUS', 'Login Commission From [[sender]] amount [[amount]] [[currency]] . Transaction: #[[transaction]]', '{\"sender\":\"Sender Name\",\"amount\":\"Received Amount\",\"currency\":\"Transfer Currency\",\"transaction\":\"Transaction Number\"}', 1, 0, 'en', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `password_resets`
--

INSERT INTO `password_resets` (`email`, `token`, `created_at`) VALUES
('admin@admin.com', '$2y$10$WzAfxfgLvDnnQj79ce5MbeW7yyD94wdukYjIYIiAInv9Mg2bkzknu', '2020-11-24 06:54:02'),
('admin@asmin.com', '$2y$10$sOgzNkgOFm9e/ZBVPNSIouMNgAii2WHL7xpLxoSVO8FeWzunvaCeG', '2020-11-24 23:42:40'),
('dcrownak@gmail.com', '$2y$10$2BQ7GuqaNtem7DvPsq9HOOmuBO.A42kspPMy7lWt3n47IUz1oBwtm', '2021-01-28 07:48:38');

-- --------------------------------------------------------

--
-- Table structure for table `payouts`
--

CREATE TABLE `payouts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `admin_id` bigint(20) UNSIGNED DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `currency_id` bigint(20) UNSIGNED DEFAULT NULL,
  `payout_method_id` bigint(20) UNSIGNED DEFAULT NULL,
  `percentage` decimal(8,4) NOT NULL DEFAULT 0.0000 COMMENT 'Percent of charge',
  `charge_percentage` decimal(16,4) NOT NULL DEFAULT 0.0000 COMMENT 'After adding percent of charge',
  `charge_fixed` decimal(16,4) NOT NULL DEFAULT 0.0000,
  `charge` decimal(16,4) NOT NULL DEFAULT 0.0000,
  `amount` decimal(16,4) NOT NULL DEFAULT 0.0000,
  `transfer_amount` decimal(16,4) NOT NULL DEFAULT 0.0000 COMMENT 'Amount deduct from sender',
  `received_amount` decimal(16,4) NOT NULL DEFAULT 0.0000 COMMENT 'Amount add to receiver',
  `charge_from` tinyint(4) NOT NULL DEFAULT 0 COMMENT '0 = Sender, 1 = Receiver',
  `note` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `withdraw_information` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 0 COMMENT '0=Pending, 1=generate, 2 = payment done, 5 = cancel',
  `utr` char(36) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `payouts`
--

INSERT INTO `payouts` (`id`, `admin_id`, `user_id`, `currency_id`, `payout_method_id`, `percentage`, `charge_percentage`, `charge_fixed`, `charge`, `amount`, `transfer_amount`, `received_amount`, `charge_from`, `note`, `withdraw_information`, `email`, `status`, `utr`, `created_at`, `updated_at`) VALUES
(1, NULL, 1, 1, 1, '0.7500', '0.0750', '1.1230', '1.1980', '10.0000', '11.1980', '10.0000', 0, NULL, '{\"account_name\":{\"fieldValue\":\"Abu Osman\",\"type\":\"text\"},\"account_number\":{\"fieldValue\":\"2588521479863\",\"type\":\"text\"},\"description\":{\"fieldValue\":\"asdfa sfsad fsa fsa\",\"type\":\"textarea\"}}', 'dcrownak@gmail.com', 1, '0c9947a9-a863-49b1-8a4e-5b7f31cf2caa', '2021-02-27 07:27:16', '2021-02-27 07:27:32'),
(2, NULL, 1, 1, 3, '0.5000', '0.5000', '1.0000', '1.5000', '100.0000', '101.5000', '100.0000', 0, NULL, NULL, 'dcrownak@gmail.com', 0, 'a49cf2a9-3930-415f-ad5a-ff32bae3f236', '2021-03-07 23:52:23', '2021-03-07 23:52:23');

-- --------------------------------------------------------

--
-- Table structure for table `payout_methods`
--

CREATE TABLE `payout_methods` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `methodName` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `inputForm` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `percentage_charge` decimal(18,8) NOT NULL DEFAULT 0.00000000,
  `fixed_charge` decimal(18,8) NOT NULL DEFAULT 0.00000000,
  `min_limit` decimal(18,8) NOT NULL DEFAULT 0.00000000,
  `max_limit` decimal(18,8) NOT NULL DEFAULT 0.00000000,
  `is_active` tinyint(4) NOT NULL DEFAULT 1 COMMENT '1 = active, 0 = inactive',
  `logo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `payout_methods`
--

INSERT INTO `payout_methods` (`id`, `methodName`, `description`, `inputForm`, `percentage_charge`, `fixed_charge`, `min_limit`, `max_limit`, `is_active`, `logo`, `created_at`, `updated_at`) VALUES
(1, 'Payoneer', 'Payment will receive within 3 days', '{\"account_name\":{\"name\":\"account_name\",\"label\":\"Account  Name\",\"type\":\"text\",\"validation\":\"required\"},\"account_number\":{\"name\":\"account_number\",\"label\":\"Account  Number\",\"type\":\"text\",\"validation\":\"required\"},\"description\":{\"name\":\"description\",\"label\":\"Description\",\"type\":\"textarea\",\"validation\":\"required\"}}', '0.75000000', '1.12300000', '1.00000000', '55.00000000', 1, 'payoneer.png', '2020-12-24 01:40:29', '2021-02-14 05:13:55'),
(2, 'Paypal', 'Payment will receive within 9 hours', '{\"account_name\":{\"name\":\"account_name\",\"label\":\"Account  Name\",\"type\":\"text\",\"validation\":\"required\"},\"account_number\":{\"name\":\"account_number\",\"label\":\"Account  Number\",\"type\":\"text\",\"validation\":\"required\"},\"description\":{\"name\":\"description\",\"label\":\"Description\",\"type\":\"textarea\",\"validation\":\"required\"}}', '0.35000000', '1.32100000', '1.00000000', '169.00000000', 1, 'paypal.png', '2020-12-24 01:40:51', '2021-02-14 05:13:33'),
(3, 'Bank', 'Payment will receive within 9 days', '{\"account_name\":{\"name\":\"account_name\",\"label\":\"Account Name\",\"type\":\"text\",\"validation\":\"required\"},\"account_number\":{\"name\":\"account_number\",\"label\":\"Account  Number\",\"type\":\"textarea\",\"validation\":\"required\"},\"deposite_slip\":{\"name\":\"deposite_slip\",\"label\":\"Deposite Slip\",\"type\":\"file\",\"validation\":\"required\"}}', '0.50000000', '1.00000000', '1.00000000', '100.00000000', 1, 'bank.png', '2020-12-28 01:23:36', '2021-02-14 05:13:43');

-- --------------------------------------------------------

--
-- Table structure for table `redeem_codes`
--

CREATE TABLE `redeem_codes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `sender_id` bigint(20) UNSIGNED DEFAULT NULL,
  `receiver_id` bigint(20) UNSIGNED DEFAULT NULL,
  `currency_id` bigint(20) UNSIGNED DEFAULT NULL,
  `percentage` decimal(8,4) NOT NULL DEFAULT 0.0000 COMMENT 'Percent of charge',
  `charge_percentage` decimal(16,4) NOT NULL DEFAULT 0.0000 COMMENT 'After adding percent of charge',
  `charge_fixed` decimal(16,4) NOT NULL DEFAULT 0.0000,
  `charge` decimal(16,4) NOT NULL DEFAULT 0.0000,
  `amount` decimal(16,4) NOT NULL DEFAULT 0.0000,
  `transfer_amount` decimal(16,4) NOT NULL DEFAULT 0.0000 COMMENT 'Amount deduct from sender',
  `received_amount` decimal(16,4) NOT NULL DEFAULT 0.0000 COMMENT 'Amount add to receiver',
  `charge_from` tinyint(4) NOT NULL DEFAULT 0 COMMENT '0 = Sender, 1 = Receiver',
  `note` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 0 COMMENT '1=Success,0=Pending',
  `utr` char(36) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `redeem_codes`
--

INSERT INTO `redeem_codes` (`id`, `sender_id`, `receiver_id`, `currency_id`, `percentage`, `charge_percentage`, `charge_fixed`, `charge`, `amount`, `transfer_amount`, `received_amount`, `charge_from`, `note`, `email`, `status`, `utr`, `created_at`, `updated_at`) VALUES
(1, 1, 2, 1, '0.5000', '0.0410', '0.6000', '0.6410', '8.2000', '8.2000', '7.5590', 1, '', 'admin@admin.com', 2, '875e21a1-eddd-48f3-b383-b8c4405bc9fa', '2020-12-06 00:25:37', '2020-12-06 00:26:59'),
(2, 1, NULL, 1, '0.5000', '0.0750', '0.6000', '0.6750', '15.0000', '15.6750', '15.0000', 0, 'Generate redeem code', NULL, 1, '22ef23c3-5219-46fe-be20-9f2e2e85c63f', '2020-12-19 04:36:29', '2021-02-03 06:24:21'),
(3, 1, NULL, 1, '0.5000', '0.1600', '0.6000', '0.7600', '32.0000', '32.7600', '32.0000', 0, 'Generate redeem code 32', NULL, 1, '50cd46bf-1072-4dd5-ba85-e2e7ec982d47', '2020-12-19 04:37:00', '2020-12-19 04:37:02'),
(4, 1, NULL, 1, '0.5000', '0.0500', '0.6000', '0.6500', '10.0000', '10.6500', '10.0000', 0, 'dafasdf asdf dsf', NULL, 1, '3970b297-c8ea-4615-bf9f-21781f650e0e', '2021-02-03 06:23:39', '2021-02-03 06:23:45');

-- --------------------------------------------------------

--
-- Table structure for table `referral_bonuses`
--

CREATE TABLE `referral_bonuses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `referral_on` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `level` int(11) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 0,
  `calcType` tinyint(4) NOT NULL DEFAULT 1 COMMENT '1 = fixed, 0 = percent',
  `amount` decimal(18,8) NOT NULL DEFAULT 0.00000000,
  `minAmount` decimal(18,8) NOT NULL DEFAULT 0.00000000,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `referral_bonuses`
--

INSERT INTO `referral_bonuses` (`id`, `referral_on`, `level`, `status`, `calcType`, `amount`, `minAmount`, `created_at`, `updated_at`) VALUES
(25, 'login', 1, 1, 1, '10.00000000', '0.00000000', '2021-03-08 03:50:44', '2021-03-08 03:50:44'),
(29, 'deposit', 1, 1, 1, '10.00000000', '25.00000000', '2021-03-08 03:57:02', '2021-03-08 03:57:02');

-- --------------------------------------------------------

--
-- Table structure for table `request_money`
--

CREATE TABLE `request_money` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `sender_id` bigint(20) UNSIGNED DEFAULT NULL COMMENT 'user id of request sender',
  `receiver_id` bigint(20) UNSIGNED DEFAULT NULL COMMENT 'user id of received receiver',
  `currency_id` bigint(20) UNSIGNED DEFAULT NULL,
  `utr` char(36) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'unique id for each payment request',
  `amount` decimal(16,4) NOT NULL DEFAULT 0.0000 COMMENT 'requested amount',
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'request receiver id',
  `note` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 0 COMMENT '1=Success,0=Pending',
  `percentage` decimal(8,4) NOT NULL DEFAULT 0.0000 COMMENT 'percent of charge',
  `charge_percentage` decimal(16,4) NOT NULL DEFAULT 0.0000 COMMENT 'after adding percent of charge',
  `charge_fixed` decimal(16,4) NOT NULL DEFAULT 0.0000,
  `charge` decimal(16,4) NOT NULL DEFAULT 0.0000,
  `transfer_amount` decimal(16,4) NOT NULL DEFAULT 0.0000 COMMENT 'amount deduct from user who (received request)',
  `received_amount` decimal(16,4) NOT NULL DEFAULT 0.0000 COMMENT 'amount add to user who send (request money)',
  `charge_from` tinyint(4) NOT NULL DEFAULT 0 COMMENT '0 = Sender, 1 = Receiver',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `request_money`
--

INSERT INTO `request_money` (`id`, `sender_id`, `receiver_id`, `currency_id`, `utr`, `amount`, `email`, `note`, `status`, `percentage`, `charge_percentage`, `charge_fixed`, `charge`, `transfer_amount`, `received_amount`, `charge_from`, `created_at`, `updated_at`) VALUES
(1, 1, 3, 1, '611fce7a-81da-43bf-9585-88079debea8c', '50.0000', 'osman_s1986@yahoo.com', 'asdf adsf asdf adsf adsf asdf', 1, '1.9000', '0.9500', '1.5000', '2.4500', '52.4500', '50.0000', 0, '2021-02-03 02:24:39', '2021-02-03 02:30:54'),
(2, 1, 3, 1, 'd5573248-7b73-48e6-9093-7f6701371368', '10.0000', 'osman_s1986@yahoo.com', '', 0, '1.9000', '0.1900', '1.5000', '1.6900', '0.0000', '0.0000', 0, '2021-02-03 02:24:59', '2021-02-03 02:24:59'),
(3, 1, 3, 1, '1ae466f4-5aaf-4556-84f6-1dd33871ae48', '10.0000', 'osman_s1986@yahoo.com', 'sdfdadfsdaf', 0, '1.9000', '0.1900', '1.5000', '1.6900', '0.0000', '0.0000', 0, '2021-02-03 02:30:40', '2021-02-03 02:30:40'),
(4, 1, 3, 1, '9a1ae468-9a27-41fb-97af-44d679db632a', '10.0000', 'osman_s1986@yahoo.com', '', 0, '1.9000', '0.1900', '1.5000', '1.6900', '0.0000', '0.0000', 0, '2021-02-08 06:02:12', '2021-02-08 06:02:12'),
(5, 1, 3, 1, '1b1d9b52-7fbf-4ff8-9fe9-d751c954f5bc', '10.0000', 'osman_s1986@yahoo.com', '', 0, '1.9000', '0.1900', '1.5000', '1.6900', '0.0000', '0.0000', 0, '2021-02-08 06:05:44', '2021-02-08 06:05:44'),
(6, 1, 3, 1, '393bdc97-ff0d-45d6-843b-aaffc3144398', '10.0000', 'osman_s1986@yahoo.com', '', 0, '1.9000', '0.1900', '1.5000', '1.6900', '0.0000', '0.0000', 0, '2021-02-08 06:09:37', '2021-02-08 06:09:37');

-- --------------------------------------------------------

--
-- Table structure for table `security_questions`
--

CREATE TABLE `security_questions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `question` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `security_questions`
--

INSERT INTO `security_questions` (`id`, `question`, `created_at`, `updated_at`) VALUES
(1, 'What was the house number and street name you lived in as a child?', '2020-11-14 01:38:42', '2020-11-14 01:39:44'),
(2, 'What were the last four digits of your childhood telephone number?', '2020-11-14 01:40:01', '2020-11-14 01:40:01'),
(3, 'What primary school did you attend?', '2020-11-14 01:40:08', '2020-11-14 01:40:08'),
(4, 'In what town or city was your first full time job?', '2020-11-14 01:40:33', '2020-11-14 01:40:33'),
(5, 'In what town or city did you meet your spouse or partner?', '2020-11-14 01:40:59', '2020-11-14 01:40:59'),
(6, 'What is the middle name of your oldest child?', '2020-11-14 01:41:06', '2020-11-14 01:41:06'),
(7, 'What are the last five digits of your driver\'s license number?', '2020-11-14 02:06:57', '2020-11-14 02:06:57'),
(8, 'What is your grandmother\'s (on your mother\'s side) maiden name?', '2020-11-14 02:07:06', '2020-11-14 02:07:06');

-- --------------------------------------------------------

--
-- Table structure for table `site_notifications`
--

CREATE TABLE `site_notifications` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `site_notificational_id` int(11) NOT NULL,
  `site_notificational_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `site_notifications`
--

INSERT INTO `site_notifications` (`id`, `site_notificational_id`, `site_notificational_type`, `description`, `created_at`, `updated_at`) VALUES
(28, 2, 'App\\Models\\Admin', '{\"link\":\"http:\\/\\/localhost\\/binary-operations\\/binary-wallet\\/admin\\/payout-list\",\"icon\":\"fa fa-money-bill-alt text-white\",\"text\":\"Abu Osman request for payment amount 10.0000 USD . Transaction: #9bbfa199-495e-4034-bcb3-a411e8dc884f\"}', '2021-02-27 07:22:16', '2021-02-27 07:22:16'),
(31, 2, 'App\\Models\\Admin', '{\"link\":\"http:\\/\\/localhost\\/binary-operations\\/binary-wallet\\/admin\\/payout-list\",\"icon\":\"fa fa-money-bill-alt text-white\",\"text\":\"Abu Osman request for payment amount 10.0000 USD . Transaction: #0c9947a9-a863-49b1-8a4e-5b7f31cf2caa\"}', '2021-02-27 07:27:33', '2021-02-27 07:27:33'),
(36, 3, 'App\\Models\\User', '{\"link\":\"http:\\/\\/localhost\\/binary-operations\\/binary-wallet\\/user\\/transfer-list\",\"icon\":\"fa fa-money-bill-alt text-white\",\"text\":\"Abu Osman send money to your account amount 10.0000 USD . Transaction: #c389f3be-971f-4b77-a5ba-915d96486fdc\"}', '2021-03-01 05:22:53', '2021-03-01 05:22:53');

-- --------------------------------------------------------

--
-- Table structure for table `sms_controls`
--

CREATE TABLE `sms_controls` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `actionMethod` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `actionUrl` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `headerData` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `paramData` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `formData` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sms_controls`
--

INSERT INTO `sms_controls` (`id`, `actionMethod`, `actionUrl`, `headerData`, `paramData`, `formData`, `created_at`, `updated_at`) VALUES
(1, 'POST', 'https://rest.nexmo.com/sms/json', '{\"Content-Type\":\"application\\/x-www-form-urlencoded\"}', NULL, '{\"from\":\"Rownak\",\"text\":\"[[message]]\",\"to\":\"[[receiver]]\",\"api_key\":\"930cc608\",\"api_secret\":\"2pijsaMOUw5YKOK5\"}', '2020-12-13 01:45:29', '2021-02-02 05:44:23');

-- --------------------------------------------------------

--
-- Table structure for table `subscribes`
--

CREATE TABLE `subscribes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `subscribes`
--

INSERT INTO `subscribes` (`id`, `email`, `created_at`, `updated_at`) VALUES
(1, 'dcrownak@email.com', '2021-01-31 01:58:54', '2021-01-31 01:58:54');

-- --------------------------------------------------------

--
-- Table structure for table `templates`
--

CREATE TABLE `templates` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `language_id` bigint(20) UNSIGNED DEFAULT NULL,
  `section_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `templates`
--

INSERT INTO `templates` (`id`, `language_id`, `section_name`, `description`, `created_at`, `updated_at`) VALUES
(1, 1, 'banner', '{\"title\":\"TRUSTED ONLINE PAYMENT PLATFORM\",\"sub_title\":\"Low Transaction Fee to Boost Your Business\",\"short_description\":\"Lorem ipsum dolor sit amet, adipisicing elit. Quod corrupti sapiente laborum,quasi? Dolor sapiente amet optio harum dolores, amet voluptate, tempora dolorem fugiat fuga autem Quod\",\"image_slogan\":\"+10  Years of Experience\"}', '2021-01-23 18:25:21', '2021-01-24 23:57:28'),
(2, 2, 'banner', '{\"title\":\"PLATAFORMA DE PAGO EN L\\u00cdNEA DE CONFIANZA\",\"sub_title\":\"Tarifa de transacci\\u00f3n baja para impulsar su negocio\",\"short_description\":\"Lorem ipsum dolor sit amet, rebajas. Los bocadillos sabios corruptos, como? La elecci\\u00f3n de muchos de estos dolores, el dolor de quien es sabio, que ame el placer, de los tiempos de la huida, sin embargo, Que huyen del dolor,\",\"image_slogan\":\"+10 a\\u00f1os de experiencia\"}', '2021-01-23 19:16:56', '2021-01-28 00:01:38'),
(3, 2, 'feature', '{\"title\":\"Nuestras caracteristicas\",\"sub_title\":\"\\u0995\\u09c7\\u09a8 \\u0986\\u09ae\\u09be\\u09a6\\u09c7\\u09b0 \\u09a8\\u09bf\\u09b0\\u09cd\\u09ac\\u09be\\u099a\\u09a8 \\u0995\\u09b0\\u09c7\\u099b\\u09c7\",\"short_description\":\"\\u0995\\u09c7\\u09a8 \\u0986\\u09ae\\u09be\\u09a6\\u09c7\\u09b0 \\u09a8\\u09bf\\u09b0\\u09cd\\u09ac\\u09be\\u099a\\u09a8 \\u0995\\u09b0\\u09c7\\u099b\\u09c7\\u0995\\u09c7\\u09a8 \\u0986\\u09ae\\u09be\\u09a6\\u09c7\\u09b0 \\u09a8\\u09bf\\u09b0\\u09cd\\u09ac\\u09be\\u099a\\u09a8 \\u0995\\u09b0\\u09c7\\u099b\\u09c7\\u0995\\u09c7\\u09a8 \\u0986\\u09ae\\u09be\\u09a6\\u09c7\\u09b0 \\u09a8\\u09bf\\u09b0\\u09cd\\u09ac\\u09be\\u099a\\u09a8 \\u0995\\u09b0\\u09c7\\u099b\\u09c7\\u0995\\u09c7\\u09a8 \\u0986\\u09ae\\u09be\\u09a6\\u09c7\\u09b0 \\u09a8\\u09bf\\u09b0\\u09cd\\u09ac\\u09be\\u099a\\u09a8 \\u0995\\u09b0\\u09c7\\u099b\\u09c7\\u0995\\u09c7\\u09a8 \\u0986\\u09ae\\u09be\\u09a6\\u09c7\\u09b0 \\u09a8\\u09bf\\u09b0\\u09cd\\u09ac\\u09be\\u099a\\u09a8 \\u0995\\u09b0\\u09c7\\u099b\\u09c7\\u0995\\u09c7\\u09a8 \\u0986\\u09ae\\u09be\\u09a6\\u09c7\\u09b0 \\u09a8\\u09bf\\u09b0\\u09cd\\u09ac\\u09be\\u099a\\u09a8 \\u0995\\u09b0\\u09c7\\u099b\\u09c7\\u0995\\u09c7\\u09a8 \\u0986\\u09ae\\u09be\\u09a6\\u09c7\\u09b0 \\u09a8\\u09bf\\u09b0\\u09cd\\u09ac\\u09be\\u099a\\u09a8 \\u0995\\u09b0\\u09c7\\u099b\\u09c7\\u0995\\u09c7\\u09a8 \\u0986\\u09ae\\u09be\\u09a6\\u09c7\\u09b0 \\u09a8\\u09bf\\u09b0\\u09cd\\u09ac\\u09be\\u099a\\u09a8 \\u0995\\u09b0\\u09c7\\u099b\\u09c7\\u0995\\u09c7\\u09a8 \\u0986\\u09ae\\u09be\\u09a6\\u09c7\\u09b0 \\u09a8\\u09bf\\u09b0\\u09cd\\u09ac\\u09be\\u099a\\u09a8 \\u0995\\u09b0\\u09c7\\u099b\\u09c7\\u0995\\u09c7\\u09a8 \\u0986\\u09ae\\u09be\\u09a6\\u09c7\\u09b0 \\u09a8\\u09bf\\u09b0\\u09cd\\u09ac\\u09be\\u099a\\u09a8 \\u0995\\u09b0\\u09c7\\u099b\\u09c7\\u0995\\u09c7\\u09a8 \\u0986\\u09ae\\u09be\\u09a6\\u09c7\\u09b0 \\u09a8\\u09bf\\u09b0\\u09cd\\u09ac\\u09be\\u099a\\u09a8 \\u0995\\u09b0\\u09c7\\u099b\\u09c7\\u0995\\u09c7\\u09a8 \\u0986\\u09ae\\u09be\\u09a6\\u09c7\\u09b0 \\u09a8\\u09bf\\u09b0\\u09cd\\u09ac\\u09be\\u099a\\u09a8 \\u0995\\u09b0\\u09c7\\u099b\\u09c7\\u0995\\u09c7\\u09a8 \\u0986\\u09ae\\u09be\\u09a6\\u09c7\\u09b0 \\u09a8\\u09bf\\u09b0\\u09cd\\u09ac\\u09be\\u099a\\u09a8 \\u0995\\u09b0\\u09c7\\u099b\\u09c7\"}', '2021-01-23 22:26:42', '2021-01-28 00:02:30'),
(4, 1, 'feature', '{\"title\":\"Our Features\",\"sub_title\":\"Why Choose Us\",\"short_description\":\"<p style=\\\"color:rgb(102,102,102);font-family:\'Open Sans\', sans-serif;font-size:14px;\\\">Lorem ipsum dolor sit amet, consectetur adipiscing elit.See quisfelis accumsan nisi Ut ut felis congue nisl hendrerit commodo.Lorem risu ipsum dolor sit amet, consectetur adipiscing elit. Duis at dictum non suscipit arcu. Quisque aliquam posuere tortor, sit amet nunc scelerisque in felis.<\\/p><p style=\\\"color:rgb(102,102,102);font-family:\'Open Sans\', sans-serif;font-size:14px;\\\">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Nemo quo laboriosam, dolorum ducimus aliquam consequuntur!<\\/p>\"}', '2021-01-23 22:27:00', '2021-01-24 23:53:54'),
(5, 1, 'about-us', '{\"title\":\"About Us\",\"sub_title\":\"Transfer and Deposite your money anytime, anywhere in the world\",\"short_description\":\"Lorem ipsum dolor sit amet, consectetur adipiscing elit.See quisfelis accum san nisi Ut ut felis congue nisl hendrerit commodo.Lorem risu ipsum dolor sit amet, consectetur adipiscing elit. Duis at dictum.\"}', '2021-01-23 22:53:59', '2021-01-23 22:53:59'),
(6, 2, 'about-us', '{\"title\":\"\\u0986\\u09ae\\u09be\\u09a6\\u09c7\\u09b0 \\u09b8\\u09ae\\u09cd\\u09aa\\u09b0\\u09cd\\u0995\\u09c7\",\"sub_title\":\"\\u09ac\\u09bf\\u09b6\\u09cd\\u09ac\\u09c7\\u09b0 \\u09af\\u09c7 \\u0995\\u09cb\\u09a8\\u0993 \\u099c\\u09be\\u09af\\u09bc\\u0997\\u09be\\u09af\\u09bc \\u0986\\u09aa\\u09a8\\u09be\\u09b0 \\u0985\\u09b0\\u09cd\\u09a5 \\u09b8\\u09cd\\u09a5\\u09be\\u09a8\\u09be\\u09a8\\u09cd\\u09a4\\u09b0 \\u098f\\u09ac\\u0982 \\u099c\\u09ae\\u09be \\u0995\\u09b0\\u09c1\\u09a8\",\"short_description\":\"\\u09ac\\u09bf\\u09b6\\u09cd\\u09ac\\u09c7\\u09b0 \\u09af\\u09c7 \\u0995\\u09cb\\u09a8\\u0993 \\u099c\\u09be\\u09af\\u09bc\\u0997\\u09be\\u09af\\u09bc \\u0986\\u09aa\\u09a8\\u09be\\u09b0 \\u0985\\u09b0\\u09cd\\u09a5 \\u09b8\\u09cd\\u09a5\\u09be\\u09a8\\u09be\\u09a8\\u09cd\\u09a4\\u09b0 \\u098f\\u09ac\\u0982 \\u099c\\u09ae\\u09be \\u0995\\u09b0\\u09c1\\u09a8 \\u09ac\\u09bf\\u09b6\\u09cd\\u09ac\\u09c7\\u09b0 \\u09af\\u09c7 \\u0995\\u09cb\\u09a8\\u0993 \\u099c\\u09be\\u09af\\u09bc\\u0997\\u09be\\u09af\\u09bc \\u0986\\u09aa\\u09a8\\u09be\\u09b0 \\u0985\\u09b0\\u09cd\\u09a5 \\u09b8\\u09cd\\u09a5\\u09be\\u09a8\\u09be\\u09a8\\u09cd\\u09a4\\u09b0 \\u098f\\u09ac\\u0982 \\u099c\\u09ae\\u09be \\u0995\\u09b0\\u09c1\\u09a8 \\u09ac\\u09bf\\u09b6\\u09cd\\u09ac\\u09c7\\u09b0 \\u09af\\u09c7 \\u0995\\u09cb\\u09a8\\u0993 \\u099c\\u09be\\u09af\\u09bc\\u0997\\u09be\\u09af\\u09bc \\u0986\\u09aa\\u09a8\\u09be\\u09b0 \\u0985\\u09b0\\u09cd\\u09a5 \\u09b8\\u09cd\\u09a5\\u09be\\u09a8\\u09be\\u09a8\\u09cd\\u09a4\\u09b0 \\u098f\\u09ac\\u0982 \\u099c\\u09ae\\u09be \\u0995\\u09b0\\u09c1\\u09a8 \\u09ac\\u09bf\\u09b6\\u09cd\\u09ac\\u09c7\\u09b0 \\u09af\\u09c7 \\u0995\\u09cb\\u09a8\\u0993 \\u099c\\u09be\\u09af\\u09bc\\u0997\\u09be\\u09af\\u09bc \\u0986\\u09aa\\u09a8\\u09be\\u09b0 \\u0985\\u09b0\\u09cd\\u09a5 \\u09b8\\u09cd\\u09a5\\u09be\\u09a8\\u09be\\u09a8\\u09cd\\u09a4\\u09b0 \\u098f\\u09ac\\u0982 \\u099c\\u09ae\\u09be \\u0995\\u09b0\\u09c1\\u09a8 \\u09ac\\u09bf\\u09b6\\u09cd\\u09ac\\u09c7\\u09b0 \\u09af\\u09c7 \\u0995\\u09cb\\u09a8\\u0993 \\u099c\\u09be\\u09af\\u09bc\\u0997\\u09be\\u09af\\u09bc \\u0986\\u09aa\\u09a8\\u09be\\u09b0 \\u0985\\u09b0\\u09cd\\u09a5 \\u09b8\\u09cd\\u09a5\\u09be\\u09a8\\u09be\\u09a8\\u09cd\\u09a4\\u09b0 \\u098f\\u09ac\\u0982 \\u099c\\u09ae\\u09be \\u0995\\u09b0\\u09c1\\u09a8\"}', '2021-01-23 22:54:58', '2021-01-23 22:54:58'),
(7, 1, 'services', '{\"title\":\"Our Services\",\"sub_title\":\"Our Best Services\",\"short_description\":\"Lorem ipsum dolor sit amet consectetur adipisicing elit. Quibusdam dolorum repellat saepe nulla illum\"}', '2021-01-23 23:14:34', '2021-01-23 23:14:34'),
(8, 2, 'services', '{\"title\":\"\\u0986\\u09ae\\u09be\\u09a6\\u09c7\\u09b0 \\u09b8\\u09c7\\u09ac\\u09be\",\"sub_title\":\"\\u0986\\u09ae\\u09be\\u09a6\\u09c7\\u09b0 \\u09b8\\u09c7\\u09b0\\u09be \\u09aa\\u09b0\\u09bf\\u09b7\\u09c7\\u09ac\\u09be\",\"short_description\":\"\\u09b8\\u09cd\\u09a8\\u09be\\u09a4\\u0995\\u09cb\\u09a4\\u09cd\\u09a4\\u09b0 \\u09aa\\u09bf\\u09a4\\u09be\\u09ae\\u09b9\\u09c0 \\u098f\\u0995\\u099a\\u09c7\\u099f\\u09bf\\u09af\\u09bc\\u09be \\u09ac\\u09bf\\u099c\\u09cd\\u099e\\u09be\\u09aa\\u09a8\\u09c7\\u09b0 \\u099c\\u09a8\\u09cd\\u09af \\u0989\\u09aa\\u09af\\u09c1\\u0995\\u09cd\\u09a4\\u0964 \\u0995\\u09c1\\u0987\\u09ac\\u09b8\\u09a6\\u09be\\u09ae \\u09a1\\u09b2\\u09cb\\u09b0\\u09bf\\u09ae \\u09b0\\u09bf\\u09aa\\u09cd\\u09b2\\u09c7\\u099f \\u09a8\\u09cd\\u09af\\u09be\\u09aa \\u0987\\u09b2\\u09bf\\u0989\\u09ae \\u09b8\\u09be\\u09aa\\u09c7\"}', '2021-01-23 23:15:29', '2021-01-23 23:15:29'),
(9, 1, 'how-it-works', '{\"title\":\"How It Works\",\"sub_title\":\"How It Works\",\"short_description\":\"How It WorksHow It WorksHow It WorksHow It WorksHow It WorksHow It Works\"}', '2021-01-23 23:37:31', '2021-01-23 23:37:31'),
(10, 2, 'how-it-works', '{\"title\":\"\\u0995\\u09bf\\u09ad\\u09be\\u09ac\\u09c7 \\u098f\\u099f\\u09be \\u0995\\u09be\\u099c \\u0995\\u09b0\\u09c7\",\"sub_title\":\"\\u0995\\u09bf\\u09ad\\u09be\\u09ac\\u09c7 \\u098f\\u099f\\u09be \\u0995\\u09be\\u099c \\u0995\\u09b0\\u09c7\\u0995\\u09bf\\u09ad\\u09be\\u09ac\\u09c7 \\u098f\\u099f\\u09be \\u0995\\u09be\\u099c \\u0995\\u09b0\\u09c7\",\"short_description\":\"\\u0995\\u09bf\\u09ad\\u09be\\u09ac\\u09c7 \\u098f\\u099f\\u09be \\u0995\\u09be\\u099c \\u0995\\u09b0\\u09c7\\u0995\\u09bf\\u09ad\\u09be\\u09ac\\u09c7 \\u098f\\u099f\\u09be \\u0995\\u09be\\u099c \\u0995\\u09b0\\u09c7\\u0995\\u09bf\\u09ad\\u09be\\u09ac\\u09c7 \\u098f\\u099f\\u09be \\u0995\\u09be\\u099c \\u0995\\u09b0\\u09c7\\u0995\\u09bf\\u09ad\\u09be\\u09ac\\u09c7 \\u098f\\u099f\\u09be \\u0995\\u09be\\u099c \\u0995\\u09b0\\u09c7\\u0995\\u09bf\\u09ad\\u09be\\u09ac\\u09c7 \\u098f\\u099f\\u09be \\u0995\\u09be\\u099c \\u0995\\u09b0\\u09c7\\u0995\\u09bf\\u09ad\\u09be\\u09ac\\u09c7 \\u098f\\u099f\\u09be \\u0995\\u09be\\u099c \\u0995\\u09b0\\u09c7\\u0995\\u09bf\\u09ad\\u09be\\u09ac\\u09c7 \\u098f\\u099f\\u09be \\u0995\\u09be\\u099c \\u0995\\u09b0\\u09c7\\u0995\\u09bf\\u09ad\\u09be\\u09ac\\u09c7 \\u098f\\u099f\\u09be \\u0995\\u09be\\u099c \\u0995\\u09b0\\u09c7\\u0995\\u09bf\\u09ad\\u09be\\u09ac\\u09c7 \\u098f\\u099f\\u09be \\u0995\\u09be\\u099c \\u0995\\u09b0\\u09c7\\u0995\\u09bf\\u09ad\\u09be\\u09ac\\u09c7 \\u098f\\u099f\\u09be \\u0995\\u09be\\u099c \\u0995\\u09b0\\u09c7\\u0995\\u09bf\\u09ad\\u09be\\u09ac\\u09c7 \\u098f\\u099f\\u09be \\u0995\\u09be\\u099c \\u0995\\u09b0\\u09c7\\u0995\\u09bf\\u09ad\\u09be\\u09ac\\u09c7 \\u098f\\u099f\\u09be \\u0995\\u09be\\u099c \\u0995\\u09b0\\u09c7\\u0995\\u09bf\\u09ad\\u09be\\u09ac\\u09c7 \\u098f\\u099f\\u09be \\u0995\\u09be\\u099c \\u0995\\u09b0\\u09c7\\u0995\\u09bf\\u09ad\\u09be\\u09ac\\u09c7 \\u098f\\u099f\\u09be \\u0995\\u09be\\u099c \\u0995\\u09b0\\u09c7\"}', '2021-01-23 23:37:45', '2021-01-23 23:37:45'),
(11, 1, 'faq', '{\"title\":\"FAQ\",\"sub_title\":\"Frequently Questions\",\"short_description\":\"Lorem ipsum dolor sit amet consectetur adipisicing elit. Quibusdam dolorum repellat saepe nulla illum\"}', '2021-01-23 23:40:39', '2021-01-23 23:40:39'),
(12, 2, 'faq', '{\"title\":\"\\u09aa\\u09cd\\u09b0\\u09b6\\u09cd\\u09a8\",\"sub_title\":\"\\u0998\\u09a8 \\u0998\\u09a8 \\u09aa\\u09cd\\u09b0\\u09b6\\u09cd\\u09a8\",\"short_description\":\"\\u09b8\\u09cd\\u09a8\\u09be\\u09a4\\u0995\\u09cb\\u09a4\\u09cd\\u09a4\\u09b0 \\u09aa\\u09bf\\u09a4\\u09be\\u09ae\\u09b9\\u09c0 \\u098f\\u0995\\u099a\\u09c7\\u099f\\u09bf\\u09af\\u09bc\\u09be \\u09ac\\u09bf\\u099c\\u09cd\\u099e\\u09be\\u09aa\\u09a8\\u09c7\\u09b0 \\u099c\\u09a8\\u09cd\\u09af \\u0989\\u09aa\\u09af\\u09c1\\u0995\\u09cd\\u09a4\\u0964 \\u0995\\u09c1\\u0987\\u09ac\\u09b8\\u09a6\\u09be\\u09ae \\u09a1\\u09b2\\u09cb\\u09b0\\u09bf\\u09ae \\u09b0\\u09bf\\u09aa\\u09cd\\u09b2\\u09c7\\u099f \\u09a8\\u09cd\\u09af\\u09be\\u09aa \\u0987\\u09b2\\u09bf\\u0989\\u09ae \\u09b8\\u09be\\u09aa\\u09c7\"}', '2021-01-23 23:41:43', '2021-01-23 23:41:43'),
(13, 1, 'mobile-app', '{\"title\":\"Mobile App\",\"sub_title\":\"Manage Your Global Payments On The Wallet Mobile App\",\"short_description\":\"Lorem ipsum, dolor sit amet consectetur, adipisicing elit. Iure laudantium expedita, earum molestias. Soluta sint ullam ex possimus blanditiis cumque reiciendis qui recusandae ipsum ad,\"}', '2021-01-24 00:13:47', '2021-01-24 00:13:47'),
(14, 1, 'clients-feedback', '{\"title\":\"Clients Feedback\",\"sub_title\":\"What our clients say\",\"short_description\":\"Lorem ipsum dolor sit amet consectetur adipisicing elit. Voluptatem consequatur consectetur dolor explicabo adipisci\"}', '2021-01-24 00:21:45', '2021-01-24 00:21:45'),
(15, 1, 'blog', '{\"title\":\"Our Blog\",\"sub_title\":\"Success Stroy Post\",\"short_description\":\"Lorem ipsum dolor sit amet consectetur adipisicing elit. Corrupti aliquid repudiandae odio voluptate nesciunt officiis qui illum\"}', '2021-01-24 00:30:10', '2021-01-27 23:48:50'),
(16, 2, 'mobile-app', '{\"title\":\"\\u09ae\\u09cb\\u09ac\\u09be\\u0987\\u09b2 \\u0985\\u09cd\\u09af\\u09be\\u09aa\",\"sub_title\":\"\\u0993\\u09af\\u09bc\\u09be\\u09b2\\u09c7\\u099f \\u09ae\\u09cb\\u09ac\\u09be\\u0987\\u09b2 \\u0985\\u09cd\\u09af\\u09be\\u09aa\\u09c7 \\u0986\\u09aa\\u09a8\\u09be\\u09b0 \\u0997\\u09cd\\u09b2\\u09cb\\u09ac\\u09be\\u09b2 \\u09aa\\u09c7\\u09ae\\u09c7\\u09a8\\u09cd\\u099f\\u0997\\u09c1\\u09b2\\u09bf \\u09aa\\u09b0\\u09bf\\u099a\\u09be\\u09b2\\u09a8\\u09be \\u0995\\u09b0\\u09c1\\u09a8\",\"short_description\":\"<p>\\u0986\\u09aa\\u09a8\\u09be\\u09b0 \\u09aa\\u099b\\u09a8\\u09cd\\u09a6\\u09b8\\u0987 \\u0995\\u09be\\u099c\\u099f\\u09bf \\u0995\\u09b0\\u09a4\\u09c7 \\u09aa\\u09be\\u09b0\\u09ac\\u09c7\\u09a8 \\u09a8\\u09be, \\u09ac\\u09bf\\u09b6\\u09c7\\u09b7\\u09a4 \\u09a6\\u0995\\u09cd\\u09b7\\u09a4\\u09be \\u0985\\u09b0\\u09cd\\u099c\\u09a8 \\u0995\\u09b0\\u09c1\\u09a8\\u0964 \\u0986\\u0987\\u0989\\u09b0 \\u09b2\\u09be\\u0989\\u09a1\\u09cd\\u09af\\u09be\\u09a8\\u09cd\\u099f\\u09bf\\u09af\\u09bc\\u09be\\u09ae \\u098f\\u0995\\u09cd\\u09b8\\u09aa\\u09bf\\u09a1\\u09c7\\u099f\\u09be, \\u0987\\u09af\\u09bc\\u09be\\u09b0\\u09ae \\u09ae\\u09cb\\u09b2\\u09b8\\u09bf\\u099f\\u09bf\\u09b8\\u0964 \\u09b8\\u09cd\\u09a8\\u09be\\u09a4\\u0995\\u09c7\\u09b0 \\u0989\\u09aa\\u09b0 \\u09a8\\u09bf\\u09b0\\u09cd\\u09ad\\u09b0 \\u0995\\u09b0\\u09c7 \\u0986\\u09aa\\u09a8\\u09bf \\u0995\\u09bf \\u09aa\\u09c1\\u09a8\\u09b0\\u09c1\\u09a6\\u09cd\\u09a7\\u09be\\u09b0 \\u0995\\u09b0\\u09a4\\u09c7 \\u09aa\\u09be\\u09b0\\u09c7\\u09a8,<br \\/><\\/p>\"}', '2021-01-25 18:53:24', '2021-01-25 18:53:24'),
(17, 2, 'clients-feedback', '{\"title\":\"Comentarios de los clientes\",\"sub_title\":\"Que dicen nuestros clientes\",\"short_description\":\"<p><span>Zanahorias Lorem ipsum mejoradas rebajas. Explicar\\u00e9 las consecuencias de una mayor experiencia de placer del consumidor.<\\/span><br \\/><\\/p>\"}', '2021-01-25 18:54:11', '2021-01-27 20:51:42'),
(18, 2, 'blog', '{\"title\":\"Blog\",\"sub_title\":\"Despu\\u00e9s del \\u00e9xito Stroy\",\"short_description\":\"<p><span>Zanahorias Lorem ipsum mejoradas rebajas. Corrompido para rechazar oficinas de placer odio no s\\u00e9 que lorem ipsum zanahorias mejoradas rebajas. Corrompido para rechazar el placer del odio oficinas que no lo conocen<\\/span><br \\/><\\/p>\"}', '2021-01-25 18:56:50', '2021-01-27 22:03:08'),
(19, 1, 'call', '{\"number\":\"+8801911105804\",\"sub_title\":\"We are here to help your Transaction Call to discuss your Solute\"}', '2021-01-25 19:18:29', '2021-01-25 19:18:29'),
(20, 2, 'call', '{\"number\":\"+8801911105804\",\"sub_title\":\"Estamos aqu\\u00ed para ayudar a su Transaction Call para discutir su Solute\"}', '2021-01-25 19:18:40', '2021-01-28 00:00:29'),
(21, 1, 'customers-content', '{\"title\":\"Our Numbers Are Talking\",\"sub_title\":\"We Always Try To Understand Customers Expectation\",\"short_description\":\"<p>More Than 20k Brand Trusted By Using Pay<br \\/><\\/p>\"}', '2021-01-27 22:21:32', '2021-01-27 22:21:32'),
(22, 2, 'customers-content', '{\"title\":\"Nuestros n\\u00fameros hablan\",\"sub_title\":\"Siempre intentamos comprender las expectativas de los clientes\",\"short_description\":\"<p>M\\u00e1s de 20.000 marcas confiables mediante Pay<br \\/><\\/p>\"}', '2021-01-27 22:21:57', '2021-01-27 23:21:38'),
(23, 1, 'subscribe', '{\"title\":\"Newslatter\",\"sub_title\":\"Subscribe Our Newslatter\"}', '2021-02-10 05:36:27', '2021-02-10 05:36:27');

-- --------------------------------------------------------

--
-- Table structure for table `template_media`
--

CREATE TABLE `template_media` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `section_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `template_media`
--

INSERT INTO `template_media` (`id`, `section_name`, `description`, `created_at`, `updated_at`) VALUES
(1, 'banner', '{\"image\":\"600d2670c10fa1611474544.jpg\",\"thumbnail\":\"6016b3390b4991612100409.jpg\"}', '2021-01-24 01:37:14', '2021-01-31 07:40:09'),
(2, 'about-us', '{\"image\":\"600f9e09f04d21611636233.jpg\",\"thumbnail\":\"600f9e0a02f021611636234.jpg\",\"youtube_link\":\"https:\\/\\/www.youtube.com\\/embed\\/OsXedJq1aWE\"}', '2021-01-24 06:12:07', '2021-01-25 22:43:54'),
(3, 'faq', '{\"image\":\"600d6424eec9f1611490340.png\"}', '2021-01-24 06:12:20', '2021-01-24 06:12:21'),
(5, 'call', '{\"image\":\"600fc2456e99c1611645509.png\"}', '2021-01-26 01:18:29', '2021-01-26 01:18:29');

-- --------------------------------------------------------

--
-- Table structure for table `tickets`
--

CREATE TABLE `tickets` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(91) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ticket` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `subject` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 0 COMMENT '0: Open, 1: Answered, 2: Replied, 3: Closed	',
  `last_reply` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tickets`
--

INSERT INTO `tickets` (`id`, `user_id`, `name`, `email`, `ticket`, `subject`, `status`, `last_reply`, `created_at`, `updated_at`) VALUES
(1, 1, 'dcrownak', 'dcrownak@gmail.com', '986243', 'Invoice copy', 1, '2021-03-17 04:06:47', '2021-01-16 01:09:11', '2021-03-17 04:06:47'),
(2, 1, 'dcrownak', 'dcrownak@gmail.com', '453959', 'Invoice copy', 3, '2021-01-16 04:53:32', '2021-01-16 01:11:52', '2021-03-17 04:06:33'),
(3, 1, 'dcrownak', 'dcrownak@gmail.com', '380865', 'Voucher Request', 1, '2021-03-17 04:09:17', '2021-01-16 01:32:51', '2021-03-17 04:09:17');

-- --------------------------------------------------------

--
-- Table structure for table `ticket_attachments`
--

CREATE TABLE `ticket_attachments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `ticket_message_id` bigint(20) UNSIGNED DEFAULT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ticket_attachments`
--

INSERT INTO `ticket_attachments` (`id`, `ticket_message_id`, `image`, `created_at`, `updated_at`) VALUES
(3, 2, '600296a33c0da1610782371.png', '2021-01-16 01:32:51', '2021-01-16 01:32:51'),
(4, 2, '600296a342cf21610782371.jpg', '2021-01-16 01:32:51', '2021-01-16 01:32:51');

-- --------------------------------------------------------

--
-- Table structure for table `ticket_messages`
--

CREATE TABLE `ticket_messages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `ticket_id` bigint(20) UNSIGNED DEFAULT NULL,
  `admin_id` bigint(20) UNSIGNED DEFAULT NULL,
  `message` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ticket_messages`
--

INSERT INTO `ticket_messages` (`id`, `ticket_id`, `admin_id`, `message`, `created_at`, `updated_at`) VALUES
(2, 3, NULL, 'New TicketNew TicketNew TicketNew Ticket', '2021-01-16 01:32:51', '2021-01-16 01:32:51'),
(3, 3, NULL, 'sadfgdfasdfadsfasdf', '2021-01-16 02:54:05', '2021-01-16 02:54:05'),
(4, 3, NULL, 'fasdfasd fasd fasd fasd fasdf asdfdsf adsfadsfdas fdasf', '2021-01-16 02:54:22', '2021-01-16 02:54:22'),
(5, 3, NULL, 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. A adipisci aperiam aspernatur atque commodi cum earum est excepturi expedita facilis harum iste iure magnam maxime minus natus necessitatibus nesciunt officia officiis perferendis, quas qui quia quod quos recusandae rem repellat rerum saepe sint soluta sunt tenetur totam voluptates. Perferendis, ullam.Lorem ipsum dolor sit amet, consectetur adipisicing elit. A adipisci aperiam aspernatur atque commodi cum earum est excepturi expedita facilis harum iste iure magnam maxime minus natus necessitatibus nesciunt officia officiis perferendis, quas qui quia quod quos recusandae rem repellat rerum saepe sint soluta sunt tenetur totam voluptates. Perferendis, ullam.', '2021-01-16 02:55:16', '2021-01-16 02:55:16'),
(6, 3, NULL, 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. A adipisci aperiam aspernatur atque commodi cum earum est excepturi expedita facilis harum iste iure magnam maxime minus natus necessitatibus nesciunt officia officiis perferendis, quas qui quia quod quos recusandae rem repellat rerum saepe sint soluta sunt tenetur totam voluptates. Perferendis, ullam.Lorem ipsum dolor sit amet, consectetur adipisicing elit. A adipisci aperiam aspernatur atque commodi cum earum est excepturi expedita facilis harum iste iure magnam maxime minus natus necessitatibus nesciunt officia officiis perferendis, quas qui quia quod quos recusandae rem repellat rerum saepe sint soluta sunt tenetur totam voluptates. Perferendis, ullam.', '2021-01-16 02:56:04', '2021-01-16 02:56:04'),
(7, 3, 1, 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. A adipisci aperiam aspernatur atque commodi cum earum est excepturi expedita facilis harum iste iure magnam maxime minus natus necessitatibus nesciunt officia officiis perferendis, quas qui quia quod quos recusandae rem repellat rerum saepe sint soluta sunt tenetur totam voluptates. Perferendis, ullam.', '2021-01-16 02:57:22', '2021-01-16 02:57:22'),
(8, 3, NULL, 'asdfasdfasdf', '2021-01-16 04:53:20', '2021-01-16 04:53:20'),
(9, 2, NULL, 'asdfdasf', '2021-01-16 04:53:32', '2021-01-16 04:53:32'),
(11, 3, 1, 'asdfadsf', '2021-01-16 23:45:41', '2021-01-16 23:45:41'),
(12, 1, 1, 'asdfasdfasdf sadf asdf', '2021-03-17 04:06:47', '2021-03-17 04:06:47'),
(13, 3, 1, 'aaaaaa', '2021-03-17 04:09:02', '2021-03-17 04:09:02'),
(14, 3, 1, 'asf sadf sadf asdf dsaf', '2021-03-17 04:09:17', '2021-03-17 04:09:17');

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `transactional_id` int(11) NOT NULL,
  `transactional_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `amount` decimal(16,4) NOT NULL DEFAULT 0.0000,
  `charge` decimal(16,4) NOT NULL DEFAULT 0.0000,
  `currency_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `transactions`
--

INSERT INTO `transactions` (`id`, `transactional_id`, `transactional_type`, `amount`, `charge`, `currency_id`, `created_at`, `updated_at`) VALUES
(1, 1, 'App\\Models\\Transfer', '14.8940', '1.2234', 1, '2020-11-30 01:29:12', '2021-02-27 02:25:57'),
(4, 2, 'App\\Models\\Transfer', '10.0000', '1.1500', 1, '2020-12-19 02:02:40', '2021-02-27 02:25:57'),
(31, 3, 'App\\Models\\Deposit', '10.0000', '2.1000', 2, '2021-01-10 23:09:34', '2021-02-27 02:26:35'),
(32, 4, 'App\\Models\\Deposit', '10.0000', '2.1500', 1, '2021-01-10 23:23:52', '2021-02-27 02:26:35'),
(33, 8, 'App\\Models\\Deposit', '10.0000', '1.0800', 1, '2021-01-11 00:53:27', '2021-02-27 02:26:35'),
(34, 13, 'App\\Models\\Deposit', '10.0000', '0.6500', 1, '2021-01-11 01:31:55', '2021-02-27 02:26:35'),
(38, 1, 'App\\Models\\Fund', '10.0000', '1.0800', 1, '2021-01-12 04:06:13', '2021-02-27 02:26:35'),
(39, 2, 'App\\Models\\Fund', '10.0000', '1.0800', 1, '2021-01-12 04:10:51', '2021-02-27 02:26:35'),
(40, 3, 'App\\Models\\Fund', '10.0000', '2.1000', 1, '2021-01-12 04:13:44', '2021-02-27 02:26:35'),
(41, 4, 'App\\Models\\Fund', '10.0000', '1.6500', 1, '2021-01-13 04:10:07', '2021-02-27 02:26:35'),
(42, 2, 'App\\Models\\Voucher', '10.0000', '1.0500', 1, '2021-01-13 06:17:54', '2021-02-27 02:26:35'),
(43, 2, 'App\\Models\\Voucher', '10.0000', '1.0500', 1, '2021-01-13 06:17:55', '2021-02-27 02:26:35'),
(44, 1, 'App\\Models\\Escrow', '55.0000', '0.8300', 1, '2021-01-14 04:12:15', '2021-02-27 02:26:35'),
(45, 1, 'App\\Models\\Escrow', '55.0000', '0.8300', 1, '2021-01-14 04:13:34', '2021-02-27 02:26:35'),
(47, 3, 'App\\Models\\Voucher', '10.0000', '1.0500', 1, '2021-01-17 01:45:27', '2021-02-27 02:26:35'),
(53, 1, 'App\\Models\\RequestMoney', '50.0000', '2.4500', 1, '2021-02-03 02:30:54', '2021-02-27 02:26:35'),
(54, 1, 'App\\Models\\Escrow', '55.0000', '0.8300', 1, '2021-02-08 00:13:01', '2021-02-27 02:26:35'),
(57, 1, 'App\\Models\\Exchange', '10.0000', '1.2000', 1, '2021-02-28 00:23:56', '2021-02-28 00:23:56'),
(58, 2, 'App\\Models\\Exchange', '250.0000', '4.7500', 2, '2021-02-28 00:50:26', '2021-02-28 00:50:26'),
(59, 5, 'App\\Models\\Transfer', '10.0000', '1.1500', 1, '2021-03-01 05:22:53', '2021-03-01 05:22:53'),
(60, 5, 'App\\Models\\Fund', '25.0000', '0.0000', 1, '2021-03-06 01:47:39', '2021-03-06 01:47:39'),
(61, 6, 'App\\Models\\Fund', '25.0000', '0.0000', 1, '2021-03-06 02:31:27', '2021-03-06 02:31:27'),
(62, 7, 'App\\Models\\Fund', '25.0000', '0.0000', 1, '2021-03-06 02:31:27', '2021-03-06 02:31:27'),
(63, 8, 'App\\Models\\Fund', '25.0000', '0.0000', 1, '2021-03-06 02:31:27', '2021-03-06 02:31:27'),
(64, 9, 'App\\Models\\Fund', '25.0000', '0.0000', 1, '2021-03-06 02:31:27', '2021-03-06 02:31:27'),
(65, 10, 'App\\Models\\Fund', '25.0000', '0.0000', 1, '2021-03-06 02:31:27', '2021-03-06 02:31:27'),
(66, 11, 'App\\Models\\Fund', '25.0000', '0.0000', 1, '2021-03-13 00:22:11', '2021-03-13 00:22:11'),
(67, 12, 'App\\Models\\Fund', '25.0000', '0.0000', 1, '2021-03-13 00:24:56', '2021-03-13 00:24:56'),
(68, 13, 'App\\Models\\Fund', '25.0000', '0.0000', 1, '2021-03-13 00:29:00', '2021-03-13 00:29:00'),
(69, 14, 'App\\Models\\Fund', '25.0000', '0.0000', 1, '2021-03-13 00:30:27', '2021-03-13 00:30:27'),
(70, 15, 'App\\Models\\Fund', '25.0000', '0.0000', 1, '2021-03-13 00:36:19', '2021-03-13 00:36:19'),
(71, 16, 'App\\Models\\Fund', '25.0000', '0.0000', 1, '2021-03-13 00:47:12', '2021-03-13 00:47:12'),
(72, 17, 'App\\Models\\Fund', '25.0000', '0.0000', 1, '2021-03-13 00:50:16', '2021-03-13 00:50:16');

-- --------------------------------------------------------

--
-- Table structure for table `transfers`
--

CREATE TABLE `transfers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `sender_id` bigint(20) UNSIGNED DEFAULT NULL,
  `receiver_id` bigint(20) UNSIGNED DEFAULT NULL,
  `currency_id` bigint(20) UNSIGNED DEFAULT NULL,
  `percentage` decimal(8,4) NOT NULL DEFAULT 0.0000 COMMENT 'Percent of charge',
  `charge_percentage` decimal(16,4) NOT NULL DEFAULT 0.0000 COMMENT 'After adding percent of charge',
  `charge_fixed` decimal(16,4) NOT NULL DEFAULT 0.0000,
  `charge` decimal(16,4) NOT NULL DEFAULT 0.0000,
  `amount` decimal(16,4) NOT NULL DEFAULT 0.0000,
  `transfer_amount` decimal(16,4) NOT NULL DEFAULT 0.0000 COMMENT 'Amount deduct from sender',
  `received_amount` decimal(16,4) NOT NULL DEFAULT 0.0000 COMMENT 'Amount add to receiver',
  `charge_from` tinyint(4) NOT NULL DEFAULT 0 COMMENT '0 = Sender, 1 = Receiver',
  `note` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 0 COMMENT '1=Success,0=Pending',
  `utr` char(36) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `transfers`
--

INSERT INTO `transfers` (`id`, `sender_id`, `receiver_id`, `currency_id`, `percentage`, `charge_percentage`, `charge_fixed`, `charge`, `amount`, `transfer_amount`, `received_amount`, `charge_from`, `note`, `email`, `status`, `utr`, `created_at`, `updated_at`) VALUES
(1, 1, 3, 1, '1.5000', '0.2234', '1.0000', '1.2234', '14.8940', '14.8940', '13.6706', 1, '', 'osman_s1986@yahoo.com', 1, '01ca269d-e037-4957-acb2-af2658bbcbb8', '2021-02-03 01:50:53', '2021-02-03 01:51:01'),
(2, 1, 3, 1, '1.5000', '0.1500', '1.0000', '1.1500', '10.0000', '11.1500', '10.0000', 0, '', 'osman_s1986@yahoo.com', 1, '65a99265-7bed-4769-82b7-8f3827a35dd1', '2021-02-08 06:04:39', '2021-02-08 06:04:41'),
(3, 1, 2, 2, '1.5000', '0.2234', '1.0000', '1.2234', '14.8940', '14.8940', '13.6706', 1, '', 'osman_s1986@yahoo.com', 1, '01ca269d-e037-4957-acb2-af2658bbcbb8', '2021-02-03 01:50:53', '2021-02-03 01:51:01'),
(4, 2, 3, 3, '1.5000', '0.1500', '1.0000', '1.1500', '10.0000', '11.1500', '10.0000', 0, '', 'osman_s1986@yahoo.com', 1, '65a99265-7bed-4769-82b7-8f3827a35dd1', '2021-02-08 06:04:39', '2021-02-08 06:04:41'),
(5, 1, 3, 1, '1.5000', '0.1500', '1.0000', '1.1500', '10.0000', '11.1500', '10.0000', 0, 'asdfasd fasdf asdf asdf asd f', 'osman_s1986@yahoo.com', 1, 'c389f3be-971f-4b77-a5ba-915d96486fdc', '2021-03-01 05:22:50', '2021-03-01 05:22:53');

-- --------------------------------------------------------

--
-- Table structure for table `two_factor_settings`
--

CREATE TABLE `two_factor_settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `security_question_id` bigint(20) UNSIGNED DEFAULT NULL,
  `answer` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Security question answer',
  `hints` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Security question answer hints',
  `security_pin` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `enable_for` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `two_factor_settings`
--

INSERT INTO `two_factor_settings` (`id`, `user_id`, `security_question_id`, `answer`, `hints`, `security_pin`, `enable_for`, `created_at`, `updated_at`) VALUES
(1, 1, 7, '11111', '11111', '$2y$10$7dzUi3S0m2e9aGGI7kHo8uE8EVaEZu78fDdTs22FAACG/g1h.qykS', '[]', '2020-11-15 00:13:06', '2021-03-14 05:22:46'),
(2, 2, NULL, NULL, NULL, NULL, NULL, '2020-11-21 00:29:07', '2020-11-21 00:29:07');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `ref_by` int(11) DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1 COMMENT '0 = inactive, 1 = active',
  `email_verification` tinyint(1) NOT NULL DEFAULT 0 COMMENT '0 = inactive, 1 = active',
  `sms_verification` tinyint(1) NOT NULL DEFAULT 0 COMMENT '0 = inactive, 1 = active',
  `verify_code` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sent_at` datetime DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `ref_by`, `name`, `username`, `email`, `email_verified_at`, `status`, `email_verification`, `sms_verification`, `verify_code`, `sent_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, NULL, 'Abu Osman', 'dcrownak', 'dcrownak@gmail.com', '2020-11-25 06:25:25', 1, 1, 1, NULL, NULL, '$2y$10$0G4wP07099yx3EEzqsnlme9q.GA.5XWF4FEMxx84/55gS3kLryAz.', NULL, '2020-11-05 01:03:39', '2021-03-17 05:18:10'),
(2, 1, 'Admin Admin', 'admin', 'admin@admin.com', '2020-11-25 06:27:07', 1, 0, 0, NULL, NULL, '$2y$12$lLXGacaUlTtR.EWkLmxMQe7ZMJpFWMJz80lU5jzZr1b9rRtZ63l8W', NULL, '2020-11-10 02:39:34', '2020-11-25 06:27:07'),
(3, 2, 'Osman Rownak', 'osman', 'osman_s1986@yahoo.com', '2021-02-03 01:53:40', 1, 1, 1, NULL, NULL, '$2y$12$vPW.qpSIy/qATuTMq0SN/OECTcGnlqs.vuzto8IOXsPdVfAdHAZxi', NULL, '2020-11-11 02:48:28', '2021-03-01 05:23:52'),
(5, 3, 'Rownak Gmail', 'rownakgmail', 'rownak@gmail.com', NULL, 1, 0, 0, NULL, NULL, '$2y$12$Nt1jCuWJ0hagCnkhDM24zuLUaIB8HHDjSE.JCJsr2wDLAs.DItF4u', NULL, '2020-11-22 00:14:21', '2020-11-22 05:37:54'),
(6, 5, 'Khan Mahmud', 'tairan', 'khan@gmail.com', NULL, 1, 0, 0, NULL, NULL, '$2y$12$XJIxnhzZIyaCRvHpK899reKNY.EIP0f4R9pzt9knUD4m2iZdUUcE.', NULL, '2020-11-22 04:03:31', '2021-02-09 05:08:57'),
(7, 6, 'A9I6SggnyP', NULL, 'tNE2XUZWE0@gmail.com', NULL, 1, 0, 0, NULL, NULL, '$2y$10$cKKjvA2oD1MJkEAyo1YeW.CBmLicNdQYwk1Tacu/QhMU9Eqigz7X2', NULL, NULL, NULL),
(8, 7, 'Ve6kQDzvsz', NULL, 'KwNFkFkFAe@gmail.com', NULL, 1, 0, 0, NULL, NULL, '$2y$10$venp7GmwSDDc2tkGYn1.Le8bsFBEzqY8ycSa4VQdpGzf9dMp4BdG2', NULL, NULL, NULL),
(9, 8, 'dcrownak1', 'dcrownak1', 'dcrownak1@gmail.com', '2021-02-11 01:11:04', 1, 0, 0, NULL, NULL, '$2y$10$PeAefA7L4/AyG/nB07ZYQOIuedGJjjLaowLuqlw11TfQg3a0m2Bxu', NULL, '2021-02-11 01:06:49', '2021-02-11 01:11:04'),
(10, 9, 'New Refferal', '01911105801', '01911105801@gmail.com', NULL, 1, 1, 1, '803054', '2021-03-06 05:45:17', '$2y$10$SEePlRVIvxDEpE4f0x96bux8Wd1fE2KqoC/o/6mxcn8Lgcr1Qgls6', NULL, '2021-03-05 23:45:09', '2021-03-05 23:45:17'),
(17, 0, 'Abu Osman', 'demouser', 'demouser@email.com', NULL, 1, 1, 1, '892854', '2021-03-13 06:50:16', '$2y$10$VGjg1EXBr49ogPs0SK5LeuEuKq8G3ctmQ3SxUQN4Xu.6edFWUxE5m', NULL, '2021-03-13 00:50:16', '2021-03-13 00:50:16');

-- --------------------------------------------------------

--
-- Table structure for table `user_profiles`
--

CREATE TABLE `user_profiles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `city` varchar(32) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `state` varchar(32) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(32) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone_code` varchar(8) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `profile_picture` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_login_at` timestamp NULL DEFAULT NULL,
  `last_login_ip` varchar(16) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_profiles`
--

INSERT INTO `user_profiles` (`id`, `user_id`, `city`, `state`, `phone`, `phone_code`, `address`, `profile_picture`, `last_login_at`, `last_login_ip`, `created_at`, `updated_at`) VALUES
(1, 1, 'Dhaka', 'Dhaka', '1611105804', '+880', 'R - 08, H - 41, Nikunja - 02, Dhaka - 1229.', 'dcrownak.jpg', '2021-03-20 01:38:32', '::1', '2020-11-25 05:20:37', '2021-03-20 01:38:32'),
(2, 2, 'Dhaka', 'Dhaka', '8801611105804', NULL, 'R - 08, H - 41, Nikunja - 02, Dhaka - 1229.', NULL, '2021-01-18 23:19:02', '127.0.0.1', '2020-11-25 06:26:36', '2021-01-18 23:19:02'),
(4, 6, 'Dhaka', 'Dhaka', '8801611105804', NULL, 'R - 08, H - 41, Nikunja - 02, Dhaka - 1229.', 'tairan.png', NULL, NULL, '2020-12-19 06:54:26', '2021-02-09 05:08:50'),
(5, 5, NULL, NULL, '8801611105804', NULL, 'R - 08, H - 41, Nikunja - 02, Dhaka - 1229.', NULL, NULL, NULL, '2020-12-20 01:08:10', '2020-12-20 01:08:10'),
(6, 3, 'Dhaka', 'Dhaka', '01911105804', NULL, 'DhakaDhakaDhakaDhaka', 'osman.png', '2021-03-01 05:54:36', '::1', '2021-02-03 02:00:36', '2021-03-01 05:54:36'),
(7, 9, 'Dhaka', 'Dhaka', '01911105804', NULL, 'H-24, R-12,Nikunja - 02, Dhaka -1229', 'dcrownak1.png', NULL, NULL, '2021-02-11 01:06:49', '2021-02-11 01:28:30'),
(8, 10, 'Dhaka', 'Dhaka', '01911105801', '+880', 'asdf asdf asdf sdaf', '01911105801.jpg', '2021-03-06 01:47:39', '::1', '2021-03-05 23:45:09', '2021-03-06 02:44:17'),
(15, 17, NULL, NULL, '1911105812', '+93', NULL, NULL, NULL, NULL, '2021-03-13 00:50:16', '2021-03-13 00:50:16'),
(16, 7, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2021-03-17 05:15:02', '2021-03-17 05:15:02'),
(17, 8, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2021-03-17 05:15:02', '2021-03-17 05:15:02');

-- --------------------------------------------------------

--
-- Table structure for table `vouchers`
--

CREATE TABLE `vouchers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `sender_id` bigint(20) UNSIGNED DEFAULT NULL,
  `receiver_id` bigint(20) UNSIGNED DEFAULT NULL,
  `currency_id` bigint(20) UNSIGNED DEFAULT NULL,
  `percentage` decimal(8,4) NOT NULL DEFAULT 0.0000 COMMENT 'Percent of charge',
  `charge_percentage` decimal(16,4) NOT NULL DEFAULT 0.0000 COMMENT 'After adding percent of charge',
  `charge_fixed` decimal(16,4) NOT NULL DEFAULT 0.0000,
  `charge` decimal(16,4) NOT NULL DEFAULT 0.0000,
  `amount` decimal(16,4) NOT NULL DEFAULT 0.0000,
  `transfer_amount` decimal(16,4) NOT NULL DEFAULT 0.0000 COMMENT 'Amount deduct from sender',
  `received_amount` decimal(16,4) NOT NULL DEFAULT 0.0000 COMMENT 'Amount add to receiver',
  `charge_from` tinyint(4) NOT NULL DEFAULT 0 COMMENT '0 = Sender, 1 = Receiver',
  `note` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 0 COMMENT '0=Pending, 1=generate, 2 = payment done, 5 = cancel',
  `utr` char(36) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `vouchers`
--

INSERT INTO `vouchers` (`id`, `sender_id`, `receiver_id`, `currency_id`, `percentage`, `charge_percentage`, `charge_fixed`, `charge`, `amount`, `transfer_amount`, `received_amount`, `charge_from`, `note`, `email`, `status`, `utr`, `created_at`, `updated_at`) VALUES
(1, 2, 1, 1, '0.5000', '0.0500', '1.0000', '1.0500', '10.0000', '10.0000', '8.9500', 1, '', 'osman@osman.com', 1, 'e1ee987c-bda2-404f-bb16-6940591787b2', '2021-02-08 04:58:56', '2021-02-08 04:58:58'),
(2, 1, 3, 1, '0.5000', '0.0500', '1.0000', '1.0500', '10.0000', '10.0000', '8.9500', 1, 'osman_s1986@yahoo.comosman_s1986@yahoo.com', 'osman_s1986@yahoo.com', 1, '43719039-6fc7-4be3-a5ea-b9e057528194', '2021-02-08 06:17:22', '2021-02-08 06:17:28'),
(3, 1, 3, 1, '0.5000', '0.0500', '1.0000', '1.0500', '10.0000', '10.0000', '8.9500', 1, 'osman_s1986@yahoo.com', 'osman_s1986@yahoo.com', 1, 'fd2b4daa-c975-455a-bfe2-8947e93e2fa9', '2021-02-08 06:19:38', '2021-02-08 06:19:41'),
(4, 1, 3, 1, '0.5000', '0.0500', '1.0000', '1.0500', '10.0000', '10.0000', '8.9500', 1, 'osman_s1986@yahoo.com', 'osman_s1986@yahoo.com', 1, '94457f5e-1564-4df1-bb13-eceafe8e784b', '2021-02-08 06:23:43', '2021-02-08 06:23:45');

-- --------------------------------------------------------

--
-- Table structure for table `wallets`
--

CREATE TABLE `wallets` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `currency_id` bigint(20) UNSIGNED DEFAULT NULL,
  `balance` decimal(16,4) NOT NULL DEFAULT 0.0000,
  `is_active` tinyint(4) NOT NULL DEFAULT 1 COMMENT '1 = active, 0 = inactive',
  `is_default` tinyint(4) NOT NULL DEFAULT 0 COMMENT '1 = default, 0 = not default',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `wallets`
--

INSERT INTO `wallets` (`id`, `user_id`, `currency_id`, `balance`, `is_active`, `is_default`, `created_at`, `updated_at`) VALUES
(1, 1, 1, '4692.1360', 1, 0, '2020-11-12 03:47:25', '2021-03-06 01:47:39'),
(2, 1, 2, '7288.0500', 1, 0, '2020-11-12 03:47:28', '2021-02-28 00:50:26'),
(3, 2, 1, '5272.1390', 1, 0, '2020-11-16 03:10:08', '2021-02-03 01:47:04'),
(4, 2, 2, '5000.0000', 1, 0, '2020-11-18 00:06:29', '2020-11-18 00:06:29'),
(5, 1, 3, '5000.0000', 1, 0, '2020-11-18 02:16:36', '2020-11-24 00:26:37'),
(6, 2, 3, '5000.0000', 1, 0, '2020-11-21 06:39:15', '2020-11-21 06:39:15'),
(7, 3, 1, '4978.6706', 1, 0, '2020-11-23 00:50:27', '2021-03-01 05:22:53'),
(8, 5, 1, '5000.0000', 1, 0, '2020-11-23 00:50:58', '2020-11-23 00:50:58'),
(9, 6, 1, '5000.0000', 1, 0, '2020-11-23 00:53:23', '2020-11-23 00:53:23'),
(11, 1, 4, '0.0000', 1, 0, '2021-02-03 06:23:18', '2021-02-03 06:23:18'),
(12, 9, 2, '0.0000', 1, 0, '2021-02-11 01:12:06', '2021-02-11 01:12:06'),
(13, 9, 1, '0.0000', 1, 0, '2021-02-11 01:12:08', '2021-03-08 04:22:52'),
(14, 9, 3, '0.0000', 1, 0, '2021-02-11 01:12:13', '2021-02-11 01:12:13'),
(15, 9, 4, '0.0000', 1, 0, '2021-02-11 01:12:15', '2021-02-11 01:12:15'),
(16, 7, 1, '125.0000', 1, 0, '2021-03-06 02:31:27', '2021-03-06 02:31:27'),
(17, 10, 2, '0.0000', 1, 0, '2021-03-06 02:34:42', '2021-03-06 02:34:42'),
(18, 10, 3, '0.0000', 1, 0, '2021-03-06 02:34:47', '2021-03-06 02:34:47'),
(19, 10, 1, '0.0000', 1, 0, '2021-03-06 02:35:05', '2021-03-06 02:35:05'),
(20, 10, 4, '0.0000', 1, 0, '2021-03-06 02:35:26', '2021-03-06 02:35:26'),
(21, 11, 1, '25.0000', 1, 0, '2021-03-13 00:22:10', '2021-03-13 00:22:11'),
(22, 11, 2, '0.0000', 1, 0, '2021-03-13 00:22:10', '2021-03-13 00:22:10'),
(23, 11, 3, '0.0000', 1, 0, '2021-03-13 00:22:10', '2021-03-13 00:22:10'),
(24, 11, 4, '0.0000', 1, 0, '2021-03-13 00:22:10', '2021-03-13 00:22:10'),
(25, 12, 1, '25.0000', 1, 0, '2021-03-13 00:24:56', '2021-03-13 00:24:56'),
(26, 12, 2, '0.0000', 1, 0, '2021-03-13 00:24:56', '2021-03-13 00:24:56'),
(27, 12, 3, '0.0000', 1, 0, '2021-03-13 00:24:56', '2021-03-13 00:24:56'),
(28, 12, 4, '0.0000', 1, 0, '2021-03-13 00:24:56', '2021-03-13 00:24:56'),
(29, 13, 1, '25.0000', 1, 0, '2021-03-13 00:29:00', '2021-03-13 00:29:00'),
(30, 13, 2, '0.0000', 1, 0, '2021-03-13 00:29:00', '2021-03-13 00:29:00'),
(31, 13, 3, '0.0000', 1, 0, '2021-03-13 00:29:00', '2021-03-13 00:29:00'),
(32, 13, 4, '0.0000', 1, 0, '2021-03-13 00:29:00', '2021-03-13 00:29:00'),
(33, 14, 1, '25.0000', 1, 0, '2021-03-13 00:30:27', '2021-03-13 00:30:27'),
(34, 14, 2, '0.0000', 1, 0, '2021-03-13 00:30:27', '2021-03-13 00:30:27'),
(35, 14, 3, '0.0000', 1, 0, '2021-03-13 00:30:27', '2021-03-13 00:30:27'),
(36, 14, 4, '0.0000', 1, 0, '2021-03-13 00:30:27', '2021-03-13 00:30:27'),
(37, 15, 1, '25.0000', 1, 0, '2021-03-13 00:36:19', '2021-03-13 00:36:19'),
(38, 15, 2, '0.0000', 1, 0, '2021-03-13 00:36:19', '2021-03-13 00:36:19'),
(39, 15, 3, '0.0000', 1, 0, '2021-03-13 00:36:19', '2021-03-13 00:36:19'),
(40, 15, 4, '0.0000', 1, 0, '2021-03-13 00:36:19', '2021-03-13 00:36:19'),
(41, 16, 1, '25.0000', 1, 0, '2021-03-13 00:47:12', '2021-03-13 00:47:12'),
(42, 16, 2, '0.0000', 1, 0, '2021-03-13 00:47:12', '2021-03-13 00:47:12'),
(43, 16, 3, '0.0000', 1, 0, '2021-03-13 00:47:12', '2021-03-13 00:47:12'),
(44, 16, 4, '0.0000', 1, 0, '2021-03-13 00:47:12', '2021-03-13 00:47:12'),
(45, 17, 1, '25.0000', 1, 0, '2021-03-13 00:50:16', '2021-03-13 00:50:16'),
(46, 17, 2, '0.0000', 1, 0, '2021-03-13 00:50:16', '2021-03-13 00:50:16'),
(47, 17, 3, '0.0000', 1, 0, '2021-03-13 00:50:16', '2021-03-13 00:50:16'),
(48, 17, 4, '0.0000', 1, 0, '2021-03-13 00:50:16', '2021-03-13 00:50:16');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `admins_email_unique` (`email`),
  ADD UNIQUE KEY `admins_username_unique` (`username`);

--
-- Indexes for table `admin_profiles`
--
ALTER TABLE `admin_profiles`
  ADD PRIMARY KEY (`id`),
  ADD KEY `admin_profiles_admin_id_foreign` (`admin_id`);

--
-- Indexes for table `basic_controls`
--
ALTER TABLE `basic_controls`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `charges_limits`
--
ALTER TABLE `charges_limits`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `commission_entries`
--
ALTER TABLE `commission_entries`
  ADD PRIMARY KEY (`id`),
  ADD KEY `commission_entries_to_user_foreign` (`to_user`),
  ADD KEY `commission_entries_from_user_foreign` (`from_user`);

--
-- Indexes for table `contacts`
--
ALTER TABLE `contacts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contents`
--
ALTER TABLE `contents`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `content_details`
--
ALTER TABLE `content_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `content_details_content_id_foreign` (`content_id`),
  ADD KEY `content_details_language_id_foreign` (`language_id`);

--
-- Indexes for table `content_media`
--
ALTER TABLE `content_media`
  ADD PRIMARY KEY (`id`),
  ADD KEY `content_media_content_id_foreign` (`content_id`);

--
-- Indexes for table `currencies`
--
ALTER TABLE `currencies`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `deposits`
--
ALTER TABLE `deposits`
  ADD PRIMARY KEY (`id`),
  ADD KEY `deposits_user_id_foreign` (`user_id`),
  ADD KEY `deposits_currency_id_foreign` (`currency_id`),
  ADD KEY `deposits_charges_limit_id_foreign` (`charges_limit_id`),
  ADD KEY `deposits_payment_method_id_foreign` (`payment_method_id`);

--
-- Indexes for table `disputes`
--
ALTER TABLE `disputes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dispute_details`
--
ALTER TABLE `dispute_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `dispute_details_dispute_id_foreign` (`dispute_id`),
  ADD KEY `dispute_details_user_id_foreign` (`user_id`),
  ADD KEY `dispute_details_admin_id_foreign` (`admin_id`);

--
-- Indexes for table `email_templates`
--
ALTER TABLE `email_templates`
  ADD PRIMARY KEY (`id`),
  ADD KEY `email_templates_language_id_foreign` (`language_id`);

--
-- Indexes for table `escrows`
--
ALTER TABLE `escrows`
  ADD PRIMARY KEY (`id`),
  ADD KEY `escrows_sender_id_foreign` (`sender_id`),
  ADD KEY `escrows_receiver_id_foreign` (`receiver_id`),
  ADD KEY `escrows_currency_id_foreign` (`currency_id`);

--
-- Indexes for table `exchanges`
--
ALTER TABLE `exchanges`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `funds`
--
ALTER TABLE `funds`
  ADD PRIMARY KEY (`id`),
  ADD KEY `funds_user_id_foreign` (`user_id`),
  ADD KEY `funds_admin_id_foreign` (`admin_id`),
  ADD KEY `funds_currency_id_foreign` (`currency_id`);

--
-- Indexes for table `gateways`
--
ALTER TABLE `gateways`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `gateways_code_unique` (`code`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `languages`
--
ALTER TABLE `languages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notify_templates`
--
ALTER TABLE `notify_templates`
  ADD PRIMARY KEY (`id`),
  ADD KEY `notify_templates_language_id_foreign` (`language_id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `payouts`
--
ALTER TABLE `payouts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `payouts_admin_id_foreign` (`admin_id`),
  ADD KEY `payouts_user_id_foreign` (`user_id`),
  ADD KEY `payouts_currency_id_foreign` (`currency_id`),
  ADD KEY `payouts_payout_method_id_foreign` (`payout_method_id`);

--
-- Indexes for table `payout_methods`
--
ALTER TABLE `payout_methods`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `redeem_codes`
--
ALTER TABLE `redeem_codes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `redeem_codes_sender_id_foreign` (`sender_id`),
  ADD KEY `redeem_codes_receiver_id_foreign` (`receiver_id`),
  ADD KEY `redeem_codes_currency_id_foreign` (`currency_id`);

--
-- Indexes for table `referral_bonuses`
--
ALTER TABLE `referral_bonuses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `request_money`
--
ALTER TABLE `request_money`
  ADD PRIMARY KEY (`id`),
  ADD KEY `request_money_sender_id_foreign` (`sender_id`),
  ADD KEY `request_money_receiver_id_foreign` (`receiver_id`),
  ADD KEY `request_money_currency_id_foreign` (`currency_id`);

--
-- Indexes for table `security_questions`
--
ALTER TABLE `security_questions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `site_notifications`
--
ALTER TABLE `site_notifications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sms_controls`
--
ALTER TABLE `sms_controls`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `subscribes`
--
ALTER TABLE `subscribes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `templates`
--
ALTER TABLE `templates`
  ADD PRIMARY KEY (`id`),
  ADD KEY `templates_language_id_foreign` (`language_id`);

--
-- Indexes for table `template_media`
--
ALTER TABLE `template_media`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tickets`
--
ALTER TABLE `tickets`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tickets_user_id_foreign` (`user_id`);

--
-- Indexes for table `ticket_attachments`
--
ALTER TABLE `ticket_attachments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ticket_attachments_ticket_message_id_foreign` (`ticket_message_id`);

--
-- Indexes for table `ticket_messages`
--
ALTER TABLE `ticket_messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ticket_messages_ticket_id_foreign` (`ticket_id`),
  ADD KEY `ticket_messages_admin_id_foreign` (`admin_id`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transfers`
--
ALTER TABLE `transfers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `two_factor_settings`
--
ALTER TABLE `two_factor_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `user_profiles`
--
ALTER TABLE `user_profiles`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_profiles_user_id_foreign` (`user_id`);

--
-- Indexes for table `vouchers`
--
ALTER TABLE `vouchers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `vouchers_sender_id_foreign` (`sender_id`),
  ADD KEY `vouchers_receiver_id_foreign` (`receiver_id`),
  ADD KEY `vouchers_currency_id_foreign` (`currency_id`);

--
-- Indexes for table `wallets`
--
ALTER TABLE `wallets`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `admin_profiles`
--
ALTER TABLE `admin_profiles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `basic_controls`
--
ALTER TABLE `basic_controls`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `charges_limits`
--
ALTER TABLE `charges_limits`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=69;

--
-- AUTO_INCREMENT for table `commission_entries`
--
ALTER TABLE `commission_entries`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `contacts`
--
ALTER TABLE `contacts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `contents`
--
ALTER TABLE `contents`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `content_details`
--
ALTER TABLE `content_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=69;

--
-- AUTO_INCREMENT for table `content_media`
--
ALTER TABLE `content_media`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `currencies`
--
ALTER TABLE `currencies`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `deposits`
--
ALTER TABLE `deposits`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `disputes`
--
ALTER TABLE `disputes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `dispute_details`
--
ALTER TABLE `dispute_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- AUTO_INCREMENT for table `email_templates`
--
ALTER TABLE `email_templates`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `escrows`
--
ALTER TABLE `escrows`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `exchanges`
--
ALTER TABLE `exchanges`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `funds`
--
ALTER TABLE `funds`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `gateways`
--
ALTER TABLE `gateways`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `languages`
--
ALTER TABLE `languages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=90;

--
-- AUTO_INCREMENT for table `notify_templates`
--
ALTER TABLE `notify_templates`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `payouts`
--
ALTER TABLE `payouts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `payout_methods`
--
ALTER TABLE `payout_methods`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `redeem_codes`
--
ALTER TABLE `redeem_codes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `referral_bonuses`
--
ALTER TABLE `referral_bonuses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `request_money`
--
ALTER TABLE `request_money`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `security_questions`
--
ALTER TABLE `security_questions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `site_notifications`
--
ALTER TABLE `site_notifications`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `sms_controls`
--
ALTER TABLE `sms_controls`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `subscribes`
--
ALTER TABLE `subscribes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `templates`
--
ALTER TABLE `templates`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `template_media`
--
ALTER TABLE `template_media`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tickets`
--
ALTER TABLE `tickets`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `ticket_attachments`
--
ALTER TABLE `ticket_attachments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `ticket_messages`
--
ALTER TABLE `ticket_messages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=73;

--
-- AUTO_INCREMENT for table `transfers`
--
ALTER TABLE `transfers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `two_factor_settings`
--
ALTER TABLE `two_factor_settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `user_profiles`
--
ALTER TABLE `user_profiles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `vouchers`
--
ALTER TABLE `vouchers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `wallets`
--
ALTER TABLE `wallets`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `admin_profiles`
--
ALTER TABLE `admin_profiles`
  ADD CONSTRAINT `admin_profiles_admin_id_foreign` FOREIGN KEY (`admin_id`) REFERENCES `admins` (`id`);

--
-- Constraints for table `commission_entries`
--
ALTER TABLE `commission_entries`
  ADD CONSTRAINT `commission_entries_from_user_foreign` FOREIGN KEY (`from_user`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `commission_entries_to_user_foreign` FOREIGN KEY (`to_user`) REFERENCES `users` (`id`);

--
-- Constraints for table `content_details`
--
ALTER TABLE `content_details`
  ADD CONSTRAINT `content_details_content_id_foreign` FOREIGN KEY (`content_id`) REFERENCES `contents` (`id`),
  ADD CONSTRAINT `content_details_language_id_foreign` FOREIGN KEY (`language_id`) REFERENCES `languages` (`id`);

--
-- Constraints for table `content_media`
--
ALTER TABLE `content_media`
  ADD CONSTRAINT `content_media_content_id_foreign` FOREIGN KEY (`content_id`) REFERENCES `contents` (`id`);

--
-- Constraints for table `deposits`
--
ALTER TABLE `deposits`
  ADD CONSTRAINT `deposits_charges_limit_id_foreign` FOREIGN KEY (`charges_limit_id`) REFERENCES `charges_limits` (`id`),
  ADD CONSTRAINT `deposits_currency_id_foreign` FOREIGN KEY (`currency_id`) REFERENCES `currencies` (`id`),
  ADD CONSTRAINT `deposits_payment_method_id_foreign` FOREIGN KEY (`payment_method_id`) REFERENCES `gateways` (`id`),
  ADD CONSTRAINT `deposits_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `dispute_details`
--
ALTER TABLE `dispute_details`
  ADD CONSTRAINT `dispute_details_admin_id_foreign` FOREIGN KEY (`admin_id`) REFERENCES `admins` (`id`),
  ADD CONSTRAINT `dispute_details_dispute_id_foreign` FOREIGN KEY (`dispute_id`) REFERENCES `disputes` (`id`),
  ADD CONSTRAINT `dispute_details_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `email_templates`
--
ALTER TABLE `email_templates`
  ADD CONSTRAINT `email_templates_language_id_foreign` FOREIGN KEY (`language_id`) REFERENCES `languages` (`id`);

--
-- Constraints for table `escrows`
--
ALTER TABLE `escrows`
  ADD CONSTRAINT `escrows_currency_id_foreign` FOREIGN KEY (`currency_id`) REFERENCES `currencies` (`id`),
  ADD CONSTRAINT `escrows_receiver_id_foreign` FOREIGN KEY (`receiver_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `escrows_sender_id_foreign` FOREIGN KEY (`sender_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `funds`
--
ALTER TABLE `funds`
  ADD CONSTRAINT `funds_admin_id_foreign` FOREIGN KEY (`admin_id`) REFERENCES `admins` (`id`),
  ADD CONSTRAINT `funds_currency_id_foreign` FOREIGN KEY (`currency_id`) REFERENCES `currencies` (`id`),
  ADD CONSTRAINT `funds_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `notify_templates`
--
ALTER TABLE `notify_templates`
  ADD CONSTRAINT `notify_templates_language_id_foreign` FOREIGN KEY (`language_id`) REFERENCES `languages` (`id`);

--
-- Constraints for table `payouts`
--
ALTER TABLE `payouts`
  ADD CONSTRAINT `payouts_admin_id_foreign` FOREIGN KEY (`admin_id`) REFERENCES `admins` (`id`),
  ADD CONSTRAINT `payouts_currency_id_foreign` FOREIGN KEY (`currency_id`) REFERENCES `currencies` (`id`),
  ADD CONSTRAINT `payouts_payout_method_id_foreign` FOREIGN KEY (`payout_method_id`) REFERENCES `payout_methods` (`id`),
  ADD CONSTRAINT `payouts_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `redeem_codes`
--
ALTER TABLE `redeem_codes`
  ADD CONSTRAINT `redeem_codes_currency_id_foreign` FOREIGN KEY (`currency_id`) REFERENCES `currencies` (`id`),
  ADD CONSTRAINT `redeem_codes_receiver_id_foreign` FOREIGN KEY (`receiver_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `redeem_codes_sender_id_foreign` FOREIGN KEY (`sender_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `request_money`
--
ALTER TABLE `request_money`
  ADD CONSTRAINT `request_money_currency_id_foreign` FOREIGN KEY (`currency_id`) REFERENCES `currencies` (`id`),
  ADD CONSTRAINT `request_money_receiver_id_foreign` FOREIGN KEY (`receiver_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `request_money_sender_id_foreign` FOREIGN KEY (`sender_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `templates`
--
ALTER TABLE `templates`
  ADD CONSTRAINT `templates_language_id_foreign` FOREIGN KEY (`language_id`) REFERENCES `languages` (`id`);

--
-- Constraints for table `tickets`
--
ALTER TABLE `tickets`
  ADD CONSTRAINT `tickets_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `ticket_attachments`
--
ALTER TABLE `ticket_attachments`
  ADD CONSTRAINT `ticket_attachments_ticket_message_id_foreign` FOREIGN KEY (`ticket_message_id`) REFERENCES `ticket_messages` (`id`);

--
-- Constraints for table `ticket_messages`
--
ALTER TABLE `ticket_messages`
  ADD CONSTRAINT `ticket_messages_admin_id_foreign` FOREIGN KEY (`admin_id`) REFERENCES `admins` (`id`),
  ADD CONSTRAINT `ticket_messages_ticket_id_foreign` FOREIGN KEY (`ticket_id`) REFERENCES `tickets` (`id`);

--
-- Constraints for table `user_profiles`
--
ALTER TABLE `user_profiles`
  ADD CONSTRAINT `user_profiles_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `vouchers`
--
ALTER TABLE `vouchers`
  ADD CONSTRAINT `vouchers_currency_id_foreign` FOREIGN KEY (`currency_id`) REFERENCES `currencies` (`id`),
  ADD CONSTRAINT `vouchers_receiver_id_foreign` FOREIGN KEY (`receiver_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `vouchers_sender_id_foreign` FOREIGN KEY (`sender_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
