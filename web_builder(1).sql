-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Apr 21, 2025 at 06:09 PM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `web_builder`
--

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sections`
--

CREATE TABLE `sections` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `html_template` text NOT NULL,
  `thumbnail` varchar(255) DEFAULT NULL,
  `slug` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sections`
--

INSERT INTO `sections` (`id`, `name`, `description`, `category_id`, `html_template`, `thumbnail`, `slug`, `created_at`, `updated_at`) VALUES
(1, 'Simple Header', 'A clean and simple header with logo and navigation', 1, '<header class=\"py-3\"><div class=\"container\"><div class=\"d-flex justify-content-between align-items-center\"><div class=\"logo\">Company Logo</div><nav><ul class=\"nav\"><li class=\"nav-item\"><a href=\"#\" class=\"nav-link\">Home</a></li><li class=\"nav-item\"><a href=\"#\" class=\"nav-link\">About</a></li><li class=\"nav-item\"><a href=\"#\" class=\"nav-link\">Services</a></li><li class=\"nav-item\"><a href=\"#\" class=\"nav-link\">Contact</a></li></ul></nav></div></div></header>', NULL, 'simple-header', '2025-04-21 14:30:26', '2025-04-21 14:30:26'),
(2, 'Hero Banner', 'Full-width hero banner with headline and CTA button', 2, '<section class=\"hero-section py-5\"><div class=\"container\"><div class=\"row align-items-center\"><div class=\"col-md-6\"><h1 class=\"hero-title\">Welcome to Our Website</h1><p class=\"hero-text\">This is a hero banner section with a headline and a call-to-action button.</p><a href=\"#\" class=\"btn btn-primary btn-lg\">Get Started</a></div><div class=\"col-md-6\"><div class=\"hero-image-placeholder\">Hero Image</div></div></div></div></section>', NULL, 'hero-banner', '2025-04-21 14:30:26', '2025-04-21 14:30:26'),
(3, 'About Us', 'Company introduction with image', 3, '<section class=\"about-section py-5 bg-light\"><div class=\"container\"><div class=\"row align-items-center\"><div class=\"col-md-6\"><div class=\"about-image-placeholder\">About Image</div></div><div class=\"col-md-6\"><h2 class=\"section-title\">About Our Company</h2><p class=\"section-text\">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p><p class=\"section-text\">Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p></div></div></div></section>', NULL, 'about-us', '2025-04-21 14:30:26', '2025-04-21 14:30:26'),
(4, 'Feature Grid', 'Grid of features with icons', 4, '<section class=\"features-section py-5\"><div class=\"container\"><h2 class=\"section-title text-center mb-5\">Our Features</h2><div class=\"row\"><div class=\"col-md-4 mb-4\"><div class=\"feature-card text-center p-4\"><div class=\"feature-icon\">🚀</div><h3 class=\"feature-title\">Feature One</h3><p class=\"feature-text\">Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p></div></div><div class=\"col-md-4 mb-4\"><div class=\"feature-card text-center p-4\"><div class=\"feature-icon\">⚡</div><h3 class=\"feature-title\">Feature Two</h3><p class=\"feature-text\">Sed do eiusmod tempor incididunt ut labore et dolore.</p></div></div><div class=\"col-md-4 mb-4\"><div class=\"feature-card text-center p-4\"><div class=\"feature-icon\">🛠️</div><h3 class=\"feature-title\">Feature Three</h3><p class=\"feature-text\">Ut enim ad minim veniam, quis nostrud exercitation.</p></div></div></div></div></section>', NULL, 'feature-grid', '2025-04-21 14:30:26', '2025-04-21 14:30:26'),
(5, 'Contact Form', 'Simple contact form with map', 6, '<section class=\"contact-section py-5\"><div class=\"container\"><h2 class=\"section-title text-center mb-5\">Contact Us</h2><div class=\"row\"><div class=\"col-md-6\"><form class=\"contact-form\"><div class=\"mb-3\"><label for=\"name\" class=\"form-label\">Your Name</label><input type=\"text\" class=\"form-control\" id=\"name\" placeholder=\"John Doe\"></div><div class=\"mb-3\"><label for=\"email\" class=\"form-label\">Email Address</label><input type=\"email\" class=\"form-control\" id=\"email\" placeholder=\"john@example.com\"></div><div class=\"mb-3\"><label for=\"message\" class=\"form-label\">Message</label><textarea class=\"form-control\" id=\"message\" rows=\"4\" placeholder=\"Your message here...\"></textarea></div><button type=\"submit\" class=\"btn btn-primary\">Send Message</button></form></div><div class=\"col-md-6\"><div class=\"map-placeholder\">Map Goes Here</div></div></div></div></section>', NULL, 'contact-form', '2025-04-21 14:30:26', '2025-04-21 14:30:26'),
(6, 'Simple Footer', 'Basic footer with copyright and links', 7, '<footer class=\"footer-section py-4\"><div class=\"container\"><div class=\"row\"><div class=\"col-md-6\"><p class=\"copyright\">© 2023 Company Name. All rights reserved.</p></div><div class=\"col-md-6 text-end\"><ul class=\"footer-links list-inline mb-0\"><li class=\"list-inline-item\"><a href=\"#\">Privacy Policy</a></li><li class=\"list-inline-item\"><a href=\"#\">Terms of Service</a></li><li class=\"list-inline-item\"><a href=\"#\">Contact</a></li></ul></div></div></div></footer>', NULL, 'simple-footer', '2025-04-21 14:30:26', '2025-04-21 14:30:26');

-- --------------------------------------------------------

--
-- Table structure for table `section_categories`
--

CREATE TABLE `section_categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `slug` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `section_categories`
--

INSERT INTO `section_categories` (`id`, `name`, `description`, `slug`, `created_at`, `updated_at`) VALUES
(1, 'Header', 'Website header sections', 'header', '2025-04-21 14:30:26', '2025-04-21 14:30:26'),
(2, 'Hero', 'Hero banner sections', 'hero', '2025-04-21 14:30:26', '2025-04-21 14:30:26'),
(3, 'About', 'About us sections', 'about', '2025-04-21 14:30:26', '2025-04-21 14:30:26'),
(4, 'Features', 'Feature list sections', 'features', '2025-04-21 14:30:26', '2025-04-21 14:30:26'),
(5, 'Testimonials', 'Customer testimonial sections', 'testimonials', '2025-04-21 14:30:26', '2025-04-21 14:30:26'),
(6, 'Contact', 'Contact form sections', 'contact', '2025-04-21 14:30:26', '2025-04-21 14:30:26'),
(7, 'Footer', 'Website footer sections', 'footer', '2025-04-21 14:30:26', '2025-04-21 14:30:26');

-- --------------------------------------------------------

--
-- Table structure for table `section_themes`
--

CREATE TABLE `section_themes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `section_id` bigint(20) UNSIGNED NOT NULL,
  `scss_template` text NOT NULL,
  `thumbnail` varchar(255) DEFAULT NULL,
  `slug` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `section_themes`
--

INSERT INTO `section_themes` (`id`, `name`, `description`, `section_id`, `scss_template`, `thumbnail`, `slug`, `created_at`, `updated_at`) VALUES
(1, 'Light Theme', 'Light background with dark text', 1, 'header { background-color: $background-color; border-bottom: 1px solid $border-color; } .logo { color: $primary-color; font-weight: bold; font-size: 1.5rem; } .nav { list-style: none; display: flex; margin: 0; padding: 0; } .nav-item { margin-left: 1.5rem; } .nav-link { color: $text-color; text-decoration: none; font-weight: 500; transition: color 0.3s; } .nav-link:hover { color: $primary-color; }', NULL, 'header-light', '2025-04-21 14:30:26', '2025-04-21 14:30:26'),
(2, 'Dark Theme', 'Dark background with light text', 1, 'header { background-color: $background-color; border-bottom: 1px solid $border-color; } .logo { color: $logo-color; font-weight: bold; font-size: 1.5rem; } .nav { list-style: none; display: flex; margin: 0; padding: 0; } .nav-item { margin-left: 1.5rem; } .nav-link { color: $text-color; text-decoration: none; font-weight: 500; transition: color 0.3s; } .nav-link:hover { color: $hover-color; }', NULL, 'header-dark', '2025-04-21 14:30:26', '2025-04-21 14:30:26'),
(3, 'Centered Hero', 'Centered text with gradient background', 2, '\r\n.hero-section { background: linear-gradient(135deg, $background-start-color, $background-end-color); color: $text-color; padding: 5rem 0; }\r\n.hero-title { font-size: 3rem; font-weight: bold; margin-bottom: 1.5rem; color: $title-color; }\r\n.hero-text { font-size: 1.25rem; margin-bottom: 2rem; }\r\n.hero-image-placeholder { background-color: rgba(255,255,255,0.2); height: 300px; border-radius: 8px; display: flex; align-items: center; justify-content: center; color: $text-color; }\r\n.btn-primary { background-color: $button-color; border-color: $button-color; }\r\n.btn-primary:hover { background-color: $button-hover-color; border-color: $button-hover-color; }\r\n', NULL, 'centered-hero', '2025-04-21 14:30:26', '2025-04-21 14:30:26'),
(4, 'Light About', 'Light background with bordered image', 3, '\r\n.about-section { background-color: $background-color; color: $text-color; }\r\n.section-title { color: $title-color; font-weight: bold; margin-bottom: 1.5rem; }\r\n.section-text { margin-bottom: 1rem; line-height: 1.6; }\r\n.about-image-placeholder { background-color: $placeholder-color; height: 300px; border-radius: 8px; border: 1px solid $border-color; display: flex; align-items: center; justify-content: center; }\r\n', NULL, 'light-about', '2025-04-21 14:30:26', '2025-04-21 14:30:26'),
(5, 'Boxed Features', 'Features in bordered boxes with shadows', 4, '\r\n.features-section { background-color: $background-color; }\r\n.section-title { color: $title-color; font-weight: bold; }\r\n.feature-card { background-color: $card-background; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); transition: transform 0.3s, box-shadow 0.3s; height: 100%; }\r\n.feature-card:hover { transform: translateY(-5px); box-shadow: 0 6px 12px rgba(0,0,0,0.1); }\r\n.feature-icon { font-size: 2.5rem; margin-bottom: 1rem; }\r\n.feature-title { color: $feature-title-color; margin-bottom: 1rem; }\r\n.feature-text { color: $text-color; }\r\n', NULL, 'boxed-features', '2025-04-21 14:30:26', '2025-04-21 14:30:26'),
(6, 'Clean Contact', 'Minimalist contact form with accent colors', 5, '\r\n.contact-section { background-color: $background-color; color: $text-color; }\r\n.section-title { color: $title-color; font-weight: bold; }\r\n.contact-form label { color: $label-color; }\r\n.contact-form .form-control { border-color: $border-color; padding: 0.75rem; }\r\n.contact-form .form-control:focus { border-color: $primary-color; box-shadow: 0 0 0 0.2rem rgba(0,123,255,0.25); }\r\n.btn-primary { background-color: $button-color; border-color: $button-color; }\r\n.btn-primary:hover { background-color: $button-hover-color; border-color: $button-hover-color; }\r\n.map-placeholder { background-color: $placeholder-color; height: 300px; border-radius: 8px; display: flex; align-items: center; justify-content: center; }\r\n', NULL, 'clean-contact', '2025-04-21 14:30:26', '2025-04-21 14:30:26'),
(7, 'Simple Dark Footer', 'Dark background with light text', 6, '\r\n.footer-section { background-color: $background-color; color: $text-color; }\r\n.copyright { margin-bottom: 0; }\r\n.footer-links a { color: $link-color; text-decoration: none; margin-left: 1rem; transition: color 0.3s; }\r\n.footer-links a:hover { color: $link-hover-color; }\r\n', NULL, 'simple-dark-footer', '2025-04-21 14:30:26', '2025-04-21 14:30:26');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `theme_variables`
--

CREATE TABLE `theme_variables` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `variable_key` varchar(255) NOT NULL,
  `default_value` varchar(255) NOT NULL,
  `section_theme_id` bigint(20) UNSIGNED NOT NULL,
  `type` varchar(255) DEFAULT 'color',
  `description` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `theme_variables`
--

INSERT INTO `theme_variables` (`id`, `name`, `variable_key`, `default_value`, `section_theme_id`, `type`, `description`, `created_at`, `updated_at`) VALUES
(1, 'Background Color', 'background-color', '#ffffff', 1, 'color', 'Background color of the header', '2025-04-21 14:25:31', '2025-04-21 14:25:31'),
(2, 'Primary Color', 'primary-color', '#007bff', 1, 'color', 'Color of the logo', '2025-04-21 14:25:31', '2025-04-21 14:25:31'),
(3, 'Text Color', 'text-color', '#333333', 1, 'color', 'Color of the navigation links', '2025-04-21 14:25:31', '2025-04-21 14:25:31'),
(4, 'Background Color', 'background-color', '#ffffff', 1, 'color', 'Header background color', '2025-04-21 14:30:26', '2025-04-21 14:30:26'),
(5, 'Border Color', 'border-color', '#eeeeee', 1, 'color', 'Bottom border color', '2025-04-21 14:30:26', '2025-04-21 14:30:26'),
(6, 'Primary Color', 'primary-color', '#007bff', 1, 'color', 'Logo and highlight color', '2025-04-21 14:30:26', '2025-04-21 14:30:26'),
(7, 'Text Color', 'text-color', '#333333', 1, 'color', 'Navigation text color', '2025-04-21 14:30:26', '2025-04-21 14:30:26'),
(8, 'Background Color', 'background-color', '#222222', 2, 'color', 'Header background color', '2025-04-21 14:30:26', '2025-04-21 14:30:26'),
(9, 'Border Color', 'border-color', '#444444', 2, 'color', 'Bottom border color', '2025-04-21 14:30:26', '2025-04-21 14:30:26'),
(10, 'Logo Color', 'logo-color', '#ffffff', 2, 'color', 'Logo text color', '2025-04-21 14:30:26', '2025-04-21 14:30:26'),
(11, 'Text Color', 'text-color', '#eeeeee', 2, 'color', 'Navigation text color', '2025-04-21 14:30:26', '2025-04-21 14:30:26'),
(12, 'Hover Color', 'hover-color', '#007bff', 2, 'color', 'Navigation hover color', '2025-04-21 14:30:26', '2025-04-21 14:30:26'),
(13, 'Start Background Color', 'background-start-color', '#4e54c8', 3, 'color', 'Gradient start color', '2025-04-21 14:30:26', '2025-04-21 14:30:26'),
(14, 'End Background Color', 'background-end-color', '#8f94fb', 3, 'color', 'Gradient end color', '2025-04-21 14:30:26', '2025-04-21 14:30:26'),
(15, 'Text Color', 'text-color', '#ffffff', 3, 'color', 'Main text color', '2025-04-21 14:30:26', '2025-04-21 14:30:26'),
(16, 'Title Color', 'title-color', '#ffffff', 3, 'color', 'Heading text color', '2025-04-21 14:30:26', '2025-04-21 14:30:26'),
(17, 'Button Color', 'button-color', '#ffffff', 3, 'color', 'Button background color', '2025-04-21 14:30:26', '2025-04-21 14:30:26'),
(18, 'Button Hover Color', 'button-hover-color', '#f8f9fa', 3, 'color', 'Button hover color', '2025-04-21 14:30:26', '2025-04-21 14:30:26'),
(19, 'Background Color', 'background-color', '#f8f9fa', 4, 'color', 'Section background color', '2025-04-21 14:30:26', '2025-04-21 14:30:26'),
(20, 'Text Color', 'text-color', '#333333', 4, 'color', 'Main text color', '2025-04-21 14:30:26', '2025-04-21 14:30:26'),
(21, 'Title Color', 'title-color', '#007bff', 4, 'color', 'Heading color', '2025-04-21 14:30:26', '2025-04-21 14:30:26'),
(22, 'Placeholder Color', 'placeholder-color', '#eeeeee', 4, 'color', 'Image placeholder color', '2025-04-21 14:30:26', '2025-04-21 14:30:26'),
(23, 'Border Color', 'border-color', '#dee2e6', 4, 'color', 'Border color', '2025-04-21 14:30:26', '2025-04-21 14:30:26'),
(24, 'Background Color', 'background-color', '#ffffff', 5, 'color', 'Section background color', '2025-04-21 14:30:26', '2025-04-21 14:30:26'),
(25, 'Title Color', 'title-color', '#007bff', 5, 'color', 'Section title color', '2025-04-21 14:30:26', '2025-04-21 14:30:26'),
(26, 'Card Background', 'card-background', '#ffffff', 5, 'color', 'Feature card background', '2025-04-21 14:30:26', '2025-04-21 14:30:26'),
(27, 'Feature Title Color', 'feature-title-color', '#333333', 5, 'color', 'Feature title color', '2025-04-21 14:30:26', '2025-04-21 14:30:26'),
(28, 'Text Color', 'text-color', '#666666', 5, 'color', 'Feature text color', '2025-04-21 14:30:26', '2025-04-21 14:30:26'),
(29, 'Background Color', 'background-color', '#ffffff', 6, 'color', 'Section background color', '2025-04-21 14:30:26', '2025-04-21 14:30:26'),
(30, 'Text Color', 'text-color', '#333333', 6, 'color', 'Main text color', '2025-04-21 14:30:26', '2025-04-21 14:30:26'),
(31, 'Title Color', 'title-color', '#007bff', 6, 'color', 'Heading color', '2025-04-21 14:30:26', '2025-04-21 14:30:26'),
(32, 'Label Color', 'label-color', '#555555', 6, 'color', 'Form label color', '2025-04-21 14:30:26', '2025-04-21 14:30:26'),
(33, 'Border Color', 'border-color', '#ced4da', 6, 'color', 'Input border color', '2025-04-21 14:30:26', '2025-04-21 14:30:26'),
(34, 'Primary Color', 'primary-color', '#007bff', 6, 'color', 'Focus highlight color', '2025-04-21 14:30:26', '2025-04-21 14:30:26'),
(35, 'Button Color', 'button-color', '#007bff', 6, 'color', 'Button background color', '2025-04-21 14:30:26', '2025-04-21 14:30:26'),
(36, 'Button Hover Color', 'button-hover-color', '#0069d9', 6, 'color', 'Button hover color', '2025-04-21 14:30:26', '2025-04-21 14:30:26'),
(37, 'Placeholder Color', 'placeholder-color', '#eeeeee', 6, 'color', 'Map placeholder color', '2025-04-21 14:30:26', '2025-04-21 14:30:26'),
(38, 'Background Color', 'background-color', '#343a40', 7, 'color', 'Footer background color', '2025-04-21 14:30:26', '2025-04-21 14:30:26'),
(39, 'Text Color', 'text-color', '#ffffff', 7, 'color', 'Footer text color', '2025-04-21 14:30:26', '2025-04-21 14:30:26'),
(40, 'Link Color', 'link-color', '#ffffff', 7, 'color', 'Footer link color', '2025-04-21 14:30:26', '2025-04-21 14:30:26'),
(41, 'Link Hover Color', 'link-hover-color', '#007bff', 7, 'color', 'Footer link hover color', '2025-04-21 14:30:26', '2025-04-21 14:30:26');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Test User', 'test@example.com', NULL, '$2y$12$dACnxl8kj/lSqwgQSpCs4usYblXshjeXOQDalqph6inTHw1kyhUF.', NULL, '2025-04-21 13:21:44', '2025-04-21 13:21:44');

-- --------------------------------------------------------

--
-- Table structure for table `websites`
--

CREATE TABLE `websites` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `published` tinyint(1) NOT NULL DEFAULT 0,
  `export_path` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `websites`
--

INSERT INTO `websites` (`id`, `name`, `description`, `user_id`, `published`, `export_path`, `created_at`, `updated_at`) VALUES
(1, 'teed', 'assdadasdasdasfas', 1, 0, NULL, '2025-04-21 13:22:15', '2025-04-21 13:22:15'),
(2, 'teed', 'assdadasdasdasfas', 1, 0, NULL, '2025-04-21 13:23:19', '2025-04-21 13:23:19'),
(3, 'teed', 'assdadasdasdasfas', 1, 0, NULL, '2025-04-21 13:25:36', '2025-04-21 13:25:36'),
(4, 'teed', 'assdadasdasdasfas', 1, 0, '/opt/lampp/htdocs/Web-builder/web-builder/storage/app/exports/4_teed.zip', '2025-04-21 13:28:25', '2025-04-21 13:45:23'),
(5, 'TEST', 'website for testing this cms', 1, 0, NULL, '2025-04-21 13:54:21', '2025-04-21 13:54:21'),
(6, 'salaheddine', 'testkfsafsdfsdfsdfsdfsdfsdf', 1, 0, '/opt/lampp/htdocs/Web-builder/web-builder/storage/app/exports/6_salaheddine.zip', '2025-04-21 13:58:57', '2025-04-21 14:02:57'),
(7, 'test', 'rewassfescsxvsvdfbdfvdvdvdv', 1, 0, NULL, '2025-04-21 14:05:48', '2025-04-21 14:05:48'),
(8, 'sxsxsx', 'sxsxsxsxsxsxs', 1, 0, NULL, '2025-04-21 14:23:19', '2025-04-21 14:23:19'),
(9, 'sdgsdsdfsdf', 'sdfsdfsdfsdfsdfsdf', 1, 0, '/opt/lampp/htdocs/Web-builder/web-builder/storage/app/exports/9_sdgsdsdfsdf.zip', '2025-04-21 14:36:21', '2025-04-21 14:41:00'),
(10, 'test', 'test', 1, 0, '/opt/lampp/htdocs/Web-builder/web-builder/storage/app/exports/10_test.zip', '2025-04-21 14:42:46', '2025-04-21 14:43:33');

-- --------------------------------------------------------

--
-- Table structure for table `website_sections`
--

CREATE TABLE `website_sections` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `website_id` bigint(20) UNSIGNED NOT NULL,
  `section_id` bigint(20) UNSIGNED NOT NULL,
  `section_theme_id` bigint(20) UNSIGNED NOT NULL,
  `order` int(11) DEFAULT 0,
  `custom_variables` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`custom_variables`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `website_sections`
--

INSERT INTO `website_sections` (`id`, `website_id`, `section_id`, `section_theme_id`, `order`, `custom_variables`, `created_at`, `updated_at`) VALUES
(1, 4, 1, 1, 1, '[]', '2025-04-21 13:31:17', '2025-04-21 13:31:17'),
(2, 4, 2, 3, 2, '[]', '2025-04-21 13:32:10', '2025-04-21 13:32:10'),
(3, 4, 3, 4, 3, '[]', '2025-04-21 13:32:37', '2025-04-21 13:32:37'),
(4, 4, 6, 7, 4, '[]', '2025-04-21 13:34:04', '2025-04-21 13:34:04'),
(5, 4, 5, 6, 5, '[]', '2025-04-21 13:34:26', '2025-04-21 13:34:26'),
(6, 5, 2, 3, 1, '[]', '2025-04-21 13:54:30', '2025-04-21 13:54:30'),
(7, 6, 2, 3, 1, '[]', '2025-04-21 14:00:05', '2025-04-21 14:00:05'),
(8, 6, 1, 1, 2, '[]', '2025-04-21 14:02:46', '2025-04-21 14:02:46'),
(9, 8, 2, 3, 1, '[]', '2025-04-21 14:23:25', '2025-04-21 14:23:25'),
(10, 8, 1, 1, 2, '{\"Background Color\":\"#ffffff\",\"Primary Color\":\"#e01b24\",\"Text Color\":\"#333333\",\"Border Color\":\"#eeeeee\"}', '2025-04-21 14:27:05', '2025-04-21 14:27:05'),
(11, 8, 2, 3, 3, '{\"Start Background Color\":\"#ed333b\",\"End Background Color\":\"#e01b24\",\"Text Color\":\"#ffffff\",\"Title Color\":\"#ffffff\",\"Button Color\":\"#ffffff\",\"Button Hover Color\":\"#f8f9fa\"}', '2025-04-21 14:27:31', '2025-04-21 14:27:31'),
(12, 8, 2, 3, 4, '{\"Start Background Color\":\"#e01b24\",\"End Background Color\":\"#8f94fb\",\"Text Color\":\"#ffffff\",\"Title Color\":\"#ffffff\",\"Button Color\":\"#ffffff\",\"Button Hover Color\":\"#f8f9fa\"}', '2025-04-21 14:30:57', '2025-04-21 14:30:57'),
(13, 8, 2, 3, 5, '{\"Start Background Color\":\"#613583\",\"End Background Color\":\"#000000\",\"Text Color\":\"#ffffff\",\"Title Color\":\"#ffffff\",\"Button Color\":\"#ffffff\",\"Button Hover Color\":\"#f8f9fa\"}', '2025-04-21 14:35:20', '2025-04-21 14:35:20'),
(14, 9, 1, 2, 1, '{\"Background Color\":\"#222222\",\"Border Color\":\"#444444\",\"Logo Color\":\"#613583\",\"Text Color\":\"#613583\",\"Hover Color\":\"#ffffff\"}', '2025-04-21 14:36:43', '2025-04-21 14:36:43'),
(15, 9, 2, 3, 2, '{\"Start Background Color\":\"#000000\",\"End Background Color\":\"#613583\",\"Text Color\":\"#f6f5f4\",\"Title Color\":\"#613583\",\"Button Color\":\"#000000\",\"Button Hover Color\":\"#f8f9fa\"}', '2025-04-21 14:37:23', '2025-04-21 14:37:23'),
(16, 9, 4, 5, 3, '{\"Background Color\":\"#000000\",\"Title Color\":\"#613583\",\"Card Background\":\"#000000\",\"Feature Title Color\":\"#c061cb\",\"Text Color\":\"#813d9c\"}', '2025-04-21 14:39:05', '2025-04-21 14:39:05'),
(17, 10, 1, 2, 1, '{\"Background Color\":\"#222222\",\"Border Color\":\"#444444\",\"Logo Color\":\"#613583\",\"Text Color\":\"#613583\",\"Hover Color\":\"#ffffff\"}', '2025-04-21 14:43:08', '2025-04-21 14:43:08'),
(18, 10, 1, 2, 2, '{\"Background Color\":\"#222222\",\"Border Color\":\"#444444\",\"Logo Color\":\"#613583\",\"Text Color\":\"#613583\",\"Hover Color\":\"#ffffff\"}', '2025-04-21 14:49:55', '2025-04-21 14:49:55'),
(19, 10, 2, 3, 3, '{\"Start Background Color\":\"#000000\",\"End Background Color\":\"#613583\",\"Text Color\":\"#ffffff\",\"Title Color\":\"#ffffff\",\"Button Color\":\"#000000\",\"Button Hover Color\":\"#f8f9fa\"}', '2025-04-21 14:50:49', '2025-04-21 14:50:49');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `sections`
--
ALTER TABLE `sections`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`);

--
-- Indexes for table `section_categories`
--
ALTER TABLE `section_categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`);

--
-- Indexes for table `section_themes`
--
ALTER TABLE `section_themes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `theme_variables`
--
ALTER TABLE `theme_variables`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `websites`
--
ALTER TABLE `websites`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `website_sections`
--
ALTER TABLE `website_sections`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `sections`
--
ALTER TABLE `sections`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `section_categories`
--
ALTER TABLE `section_categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `section_themes`
--
ALTER TABLE `section_themes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `theme_variables`
--
ALTER TABLE `theme_variables`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `websites`
--
ALTER TABLE `websites`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `website_sections`
--
ALTER TABLE `website_sections`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
