<?php
/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://cleandesk.ai
 * @since             1.0.0
 * @package           Cleandesk_Ai
 *
 * @wordpress-plugin
 * Plugin Name:       CleanDesk AI
 * Plugin URI:        https://cleandesk.ai
 * Description:       CleanDesk AI is a WordPress plugin that allows you to easily integrate the CleanDesk AI chat widget into your website.
 * Version:           1.0.0
 * Author:            CleanDesk AI
 * Author URI:        https://cleandesk.ai/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       cleandesk-ai
 */

if ( ! defined( 'WPINC' ) ) {
	die;
}

function cdaiw_enqueue_scripts() {
  $random_string = wp_generate_password(8, false);

  $cleandeskVersion = '1.0.0';

  wp_enqueue_script('clean-ai-bot-script', 'https://cdn.cleandesk.co.in/public/build/clean_ai_bot.js?q=' . $random_string, array(), $cleandeskVersion, true);
}

function cdaiw_integration() {
  $app_id = get_option('cdaiw_app_id');
  $app_secret = get_option('cdaiw_app_secret');

  ?>
    <script>
      console.log('CleanDesk AI Integration');
    </script>

  <?php

  if ($app_id && $app_secret) {
    if (is_user_logged_in()) {

      $current_user = wp_get_current_user();
      $user_id = $current_user->ID;

      echo '<script>';
      echo "document.write('<cleandesk-chat-widget app_id=" . esc_attr($app_id) . " app_secret=" . esc_attr($app_secret) . " access_by_id=" . esc_attr($user_id) . "></cleandesk-chat-widget>')";
      echo '</script>';

    } else {

      echo '<script>';
      echo "document.write('<cleandesk-chat-widget app_id=" . esc_attr($app_id) . " app_secret=" . esc_attr($app_secret) . "></cleandesk-chat-widget>')";
      echo '</script>';
    }
  }
}

// Hook the function to the wp_footer action
// if ( is_plugin_active( plugin_basename( __FILE__ ) ) ) {
//   add_action('wp_enqueue_scripts', 'cdaiw_enqueue_scripts');
//   add_action('wp_footer', 'cdaiw_integration');
// }

add_action('wp_enqueue_scripts', 'cdaiw_enqueue_scripts');
add_action('wp_footer', 'cdaiw_integration');

// Add settings menu to the admin dashboard.
function cdaiw_admin_menu() {
  $base64_icon = 'PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iVVRGLTgiPz4KPHN2ZyBpZD0iTGF5ZXJfMSIgZGF0YS1uYW1lPSJMYXllciAxIiB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHZpZXdCb3g9IjAgMCAxMDI0IDEwMjQiPgogIDxkZWZzPgogICAgPHN0eWxlPgogICAgICAuY2xzLTEgewogICAgICAgIGZpbGw6IG5vbmU7CiAgICAgIH0KCiAgICAgIC5jbHMtMSwgLmNscy0yLCAuY2xzLTMsIC5jbHMtNCB7CiAgICAgICAgc3Ryb2tlLXdpZHRoOiAwcHg7CiAgICAgIH0KCiAgICAgIC5jbHMtMiB7CiAgICAgICAgZmlsbDogI2YyZjJmZjsKICAgICAgfQoKICAgICAgLmNscy0zIHsKICAgICAgICBmaWxsOiAjZmZmOwogICAgICB9CgogICAgICAuY2xzLTQgewogICAgICAgIGZpbGw6IGJsdWU7CiAgICAgIH0KICAgIDwvc3R5bGU+CiAgPC9kZWZzPgogIDxyZWN0IGNsYXNzPSJjbHMtMSIgd2lkdGg9IjEwMjQiIGhlaWdodD0iMTAyNCIvPgogIDxnPgogICAgPHBhdGggY2xhc3M9ImNscy0zIiBkPSJNNzA4LjM3LDI4MC44MWMyOC4xNiwzNS45NCw1My40LDEyMi43Myw2NC45NiwxNjguMzEsMy4zMyw1LjA2LDYuMjMsMTAuNDcsOC43MywxNi4yNiwxLjU3LTQ1LjE3LDEuNDUtMTIyLjkyLTEyLjgxLTE1OS4zNS0yMC43NS01My4wMy0xNjIuMTMtMjE0Ljc2LTE4Ny4zNi0yMjYuMi0zLjkzLTEuNzktOC4xMy0yLjY5LTEyLjQ3LTIuNjktMTAuOTcsMC0yMS44OSw1LjgzLTI4LjUyLDE1LjIxLTYuNDEsOS4wOC03Ljg0LDE5Ljk4LTQuMDQsMzAuNjksMy4zNiw5LjQ1LDEzLjk1LDI2Ljg1LDI3LDQ2Ljg2LDYwLjg3LDM5LjEzLDEyNS4xMSw4Ni4xNiwxNDQuNSwxMTAuOVoiLz4KICAgIDxwYXRoIGNsYXNzPSJjbHMtNCIgZD0iTTc3Ni44OSwzMDMuMDVjLTIwLjI4LTUxLjgzLTE2MS41LTIxNy4wMy0xOTEuNjEtMjMwLjY4LTUtMi4yNy0xMC4zNC0zLjQyLTE1Ljg1LTMuNDItMTMuNTksMC0yNy4wOCw3LjE2LTM1LjIxLDE4LjY4LTcuOTksMTEuMzItOS43OSwyNC44Ny01LjA2LDM4LjE3LDIuNzMsNy42OSw5LjQ0LDE5LjU0LDE4LjMzLDMzLjcyLTQ2LjY1LTI5LjE4LTg4LjYyLTUxLjkyLTEwMy4wNC01My44Ni0xNy42NS0yLjM3LTM1LjY1LDcuNzMtNDQuMTksMjQuNTktNy42OSwxNS4xOC02LjI1LDMyLjQ1LDMuODQsNDYuMTksMTAuNTQsMTQuMzYsNDMuNjQsNDEuNTIsNzguNjgsNzAuMjgsMzMuNTksMjcuNTcsNjguMTYsNTUuOTQsODEuNTcsNzIuMTEtMzkuNzctMTcuMDUtODIuNC0zMS40Mi0xMTMuMTgtMzEuNDItMTEuMzgsMC0yMC43NSwyLTI3Ljg2LDUuOTUtNDYuMzUsMjUuNzUtMTgzLjAxLDE0OS4xOS0xODYuNzQsMTc5LjAyLTIuMTEsMTYuODEsNS4wMSwzNy43NywxNy43MSw1Mi4xNSw4LjksMTAuMDgsMTkuNjEsMTUuNjMsMzAuMTYsMTUuNjNoMGMxLjkxLDAsMy44NC0uMTgsNS43My0uNTQsMTEuODctMi4yMywzMy4yLTE5LjEsNjAuMi00MC40NywzOC40Ny0zMC40NSw4Ni42LTY4Ljc4LDExMi43OC02NS43NSwxMy41MywxLjU2LDI3Ljg2LDE0LjIzLDQwLjM2LDM1LjY2LDIyLjM0LDM4LjMyLDMxLjg2LDkyLjc5LDIwLjc5LDExOC45NC0xNy44LDQyLjA3LTM5LjQ2LDcwLjA4LTg3LjMzLDcwLjA4LTguNywwLTE4LjIzLS45Ni0yOC4zNS0yLjg0LTU5Ljc1LTExLjEyLTczLjI5LTQ3LjA0LTgzLjE4LTczLjI4LTIuMDgtNS41Mi00LjA0LTEwLjczLTYuMjMtMTUuMTEtNy43Mi0xNS40NC0zMS45NS0yOC40OC01Mi45Mi0yOC40OC0xNS45MywwLTI2Ljc0LDcuNTUtMjkuNjYsMjAuNzEtNi4wNSwyNy4yLTEwLjUxLDk2LjU3LDE1Ljg2LDE2NC4zOSwyNi43OCw2OC44OCw3OS42OCwxMTguNjIsMTQ4Ljk0LDE0MC4wNiwzNy42NiwxMS42Niw1OS4xMSwzMi4yMSw3OC4wMyw1MC4zNSwxNy41LDE2Ljc3LDM0LjAyLDMyLjYxLDU5Ljg5LDM4LjU4LDcuMzgsMS43LDE1LjkyLDIuNTcsMjUuMzcsMi41Nyw0OS4xOSwwLDEyNC4wNC0yMy4xOCwxODAuNC03NC45Nyw0Ny41NS00My42OSw0Mi44MS0xMDUuNiwzOC4yMy0xNjUuNDctMS44Mi0yMy43NC0zLjU0LTQ2LjE3LTIuMDctNjcuMjIsMS40NC0yMC42NCwzLjUxLTM5LjUxLDUuNTEtNTcuNzUsNC4zNi0zOS43Myw3LjkyLTcyLjUyLDIuMzctMTAxLjA1LDIuMjUtMzYuMzQsNS41OC0xMzkuOTMtMTIuMjctMTg1LjU1Wk01NjQuNzIsOTQ2Ljg2Yy04Ljg0LDAtMTYuNzUtLjc5LTIzLjUzLTIuMzYtMjMuNjYtNS40Ni0zOC42Ny0xOS44NS01Ni4wNi0zNi41MS0xOS41Ny0xOC43Ni00MS43Ni00MC4wMy04MS4yNy01Mi4yNi02Ni44My0yMC42OS0xMTcuODctNjguNy0xNDMuNzMtMTM1LjItMjMuOC02MS4yLTIyLjMtMTI5LTE1LjQ5LTE1OS42NCwyLjYyLTExLjgxLDEzLjIyLTE0LjI5LDIxLjY1LTE0LjI5LDE3LjksMCwzOS4yMSwxMS4xOSw0NS41OCwyMy45NSwyLDQsMy44OSw5LjAyLDUuODksMTQuMzMsOS45OCwyNi40OCwyNS4wNSw2Ni40OSw4OS4zNSw3OC40NSwxMC42MSwxLjk3LDIwLjY1LDIuOTcsMjkuODUsMi45Nyw1NS40NywwLDc4LjM4LTM2LjA5LDk0Ljg4LTc1LjA5LDEzLjYtMzIuMTQtLjQ1LTkwLjU3LTIxLjI2LTEyNi4yNy0xMy44My0yMy43Mi0zMC4zNC0zNy44MS00Ni41LTM5LjY3LTI5LjExLTMuNDMtNzYuOTUsMzQuMzMtMTE4LjgsNjcuNDYtMjQuMDQsMTkuMDItNDYuNzQsMzctNTYuNjMsMzguODUtMS4zOS4yNi0yLjgxLjM5LTQuMjIuMzloMGMtOC4xNiwwLTE2LjY5LTQuNTctMjQuMDEtMTIuODYtMTEuMDUtMTIuNTItMTcuNTItMzEuMzItMTUuNzItNDUuNzEsMy4yLTI1LjU5LDEzMy43Mi0xNDUuNzMsMTgyLjU4LTE3Mi44Nyw1Ljg4LTMuMjYsMTMuOTEtNC45MiwyMy44OC00LjkyLDY5LjI3LDAsMjAyLjcyLDc2LjMxLDIxNy43LDg1LjAybDkuOCw1LjY3YzQ4LjczLDI4LjE3LDgzLjk1LDQ4LjUyLDk4LjE2LDg3Ljk5LDExLjAyLDMwLjYxLDYuOTYsNjcuNjEsMS44MiwxMTQuNDYtMi4wMSwxOC4zMy00LjA5LDM3LjI4LTUuNTQsNTguMDgtMS41MSwyMS42NS4yMyw0NC4zNywyLjA3LDY4LjQyLDQuNDMsNTcuOTIsOS4wMiwxMTcuOC0zNS42LDE1OC44MS01NC40NCw1MC4wMi0xMjguOCw3Mi44MS0xNzQuODYsNzIuODFaTTU3NS42NiwzMjAuNTZjLTkuMDQtMTUuNjQtNDcuMjUtNDYuOTktODcuNjktODAuMTgtMzMuMTEtMjcuMTgtNjcuMzUtNTUuMjctNzcuMjgtNjguOC04LjM1LTExLjM3LTkuNDktMjUuMDktMy4xMy0zNy42NCw2Ljk5LTEzLjgsMjEuNTctMjIuMDcsMzUuNzgtMjAuMTcsMjkuMDQsMy45MiwyMjEuNDQsMTI0LjcsMjU4LjU4LDE3Mi4wOSwyMy44OSwzMC40Nyw0Ni4wOSwxMDAuNjgsNTguODEsMTQ3LjUtMTguOS0xOS45Ny00NS41LTM1LjQtNzcuOTctNTQuMTZsLTkuNzgtNS42NmMtNy44OC00LjU4LTQ4LjE2LTI3LjYyLTk1LjA1LTQ4LjczLS43Ni0xLjUyLTEuNTItMi45Ni0yLjI3LTQuMjVaTTU0MC45MSw5Mi4zNmM2LjYzLTkuMzgsMTcuNTUtMTUuMjEsMjguNTItMTUuMjEsNC4zNCwwLDguNTQuOSwxMi40NywyLjY5LDI1LjIzLDExLjQ0LDE2Ni42MSwxNzMuMTcsMTg3LjM2LDIyNi4yLDE0LjI1LDM2LjQ0LDE0LjM4LDExNC4xOCwxMi44MSwxNTkuMzUtMi40OS01LjgtNS40LTExLjItOC43My0xNi4yNi0xMS41Ni00NS41OC0zNi43OS0xMzIuMzctNjQuOTYtMTY4LjMxLTE5LjM5LTI0Ljc0LTgzLjYzLTcxLjc4LTE0NC41LTExMC45LTEzLjA1LTIwLjAxLTIzLjY0LTM3LjQxLTI3LTQ2Ljg2LTMuODEtMTAuNzEtMi4zNy0yMS42MSw0LjA0LTMwLjY5WiIvPgogICAgPHBhdGggY2xhc3M9ImNscy0zIiBkPSJNNjcyLjk4LDM3My41NGw5Ljc4LDUuNjZjMzIuNDcsMTguNzcsNTkuMDcsMzQuMiw3Ny45Nyw1NC4xNi0xMi43My00Ni44MS0zNC45My0xMTcuMDItNTguODEtMTQ3LjUtMzcuMTQtNDcuMzktMjI5LjU1LTE2OC4xOC0yNTguNTgtMTcyLjA5LTE0LjIxLTEuOS0yOC43OSw2LjM3LTM1Ljc4LDIwLjE3LTYuMzUsMTIuNTUtNS4yMSwyNi4yNywzLjEzLDM3LjY0LDkuOTMsMTMuNTMsNDQuMTcsNDEuNjIsNzcuMjgsNjguOCw0MC40NSwzMy4xOSw3OC42NSw2NC41NCw4Ny42OSw4MC4xOC43NSwxLjI5LDEuNTEsMi43MywyLjI3LDQuMjUsNDYuODksMjEuMSw4Ny4xNiw0NC4xNSw5NS4wNSw0OC43M1oiLz4KICAgIDxwYXRoIGNsYXNzPSJjbHMtMyIgZD0iTTc3NS4xNyw3MTUuMjRjLTEuODQtMjQuMDUtMy41OC00Ni43Ni0yLjA3LTY4LjQyLDEuNDUtMjAuOCwzLjUzLTM5Ljc1LDUuNTQtNTguMDgsNS4xNC00Ni44NCw5LjItODMuODQtMS44Mi0xMTQuNDYtMTQuMjEtMzkuNDctNDkuNDItNTkuODItOTguMTYtODcuOTlsLTkuOC01LjY3Yy0xNC45OS04LjctMTQ4LjQzLTg1LjAyLTIxNy43LTg1LjAyLTkuOTcsMC0xOCwxLjY2LTIzLjg4LDQuOTItNDguODYsMjcuMTQtMTc5LjM4LDE0Ny4yOC0xODIuNTgsMTcyLjg3LTEuOCwxNC4zOSw0LjY2LDMzLjE5LDE1LjcyLDQ1LjcxLDcuMzIsOC4yOSwxNS44NSwxMi44NiwyNC4wMSwxMi44NmgwYzEuNDEsMCwyLjgzLS4xMyw0LjIyLS4zOSw5Ljg4LTEuODUsMzIuNTktMTkuODMsNTYuNjMtMzguODUsNDEuODUtMzMuMTMsODkuNjktNzAuODksMTE4LjgtNjcuNDYsMTYuMTYsMS44NywzMi42NywxNS45NSw0Ni41LDM5LjY3LDIwLjgxLDM1LjcsMzQuODYsOTQuMTMsMjEuMjYsMTI2LjI3LTE2LjUsMzktMzkuNDEsNzUuMDktOTQuODgsNzUuMDktOS4yLDAtMTkuMjQtMS0yOS44NS0yLjk3LTY0LjMtMTEuOTYtNzkuMzgtNTEuOTgtODkuMzUtNzguNDUtMi01LjMxLTMuODktMTAuMzMtNS44OS0xNC4zMy02LjM4LTEyLjc2LTI3LjY4LTIzLjk1LTQ1LjU4LTIzLjk1LTguNDMsMC0xOS4wMywyLjQ4LTIxLjY1LDE0LjI5LTYuODEsMzAuNjQtOC4zLDk4LjQ0LDE1LjQ5LDE1OS42NCwyNS44Niw2Ni41LDc2LjksMTE0LjUxLDE0My43MywxMzUuMiwzOS41MSwxMi4yMyw2MS43LDMzLjUsODEuMjcsNTIuMjYsMTcuMzgsMTYuNjYsMzIuMzksMzEuMDUsNTYuMDYsMzYuNTEsNi43OCwxLjU3LDE0LjcsMi4zNiwyMy41MywyLjM2LDQ2LjA2LDAsMTIwLjQyLTIyLjc4LDE3NC44Ni03Mi44MSw0NC42Mi00MSw0MC4wMy0xMDAuODksMzUuNi0xNTguODFaIi8+CiAgICA8cGF0aCBjbGFzcz0iY2xzLTIiIGQ9Ik02MzMuNTgsMzA5LjYyYy0xMi42OS04LjU4LTI2LTE2LjItMzkuMDktMjQuMTYtNTguMTEtMzUuMzEtMTEyLjE0LTc3LjM0LTE2MC42Ni0xMjQuOTktNi45OS02Ljg2LTEzLjk5LTE0LjAyLTE4LjI2LTIyLjgzLTEuNjQtMy4zOC0yLjgtNy4wNy0zLjM2LTEwLjgyLTEuNzgsMi4xNi0zLjM2LDQuNTUtNC42Niw3LjEzLTYuMzUsMTIuNTUtNS4yMSwyNi4yNywzLjEzLDM3LjY0LDkuOTMsMTMuNTMsNDQuMTcsNDEuNjIsNzcuMjgsNjguOCw0MC40NSwzMy4xOSw3OC42NSw2NC41NCw4Ny42OSw4MC4xOC43NSwxLjI5LDEuNTEsMi43MywyLjI3LDQuMjUsNDYuODksMjEuMSw4Ny4xNiw0NC4xNSw5NS4wNSw0OC43M2w5Ljc4LDUuNjZjMTQuODMsOC41NywyOC4zNywxNi40NSw0MC41OCwyNC4zOC0yMi45MS0zNy4xNC01My42LTY5LjUyLTg5Ljc2LTkzLjk3WiIvPgogICAgPHBhdGggY2xhc3M9ImNscy0yIiBkPSJNNzgyLjA2LDQ2NS4zOWMuMTgtNS4wOS4zMy0xMC42Mi40NS0xNi40NC0zLjQyLTEzLjEtNi45My0yNi4xOC0xMC40NS0zOS4yNS0zLjU5LTEzLjM0LTcuMTgtMjYuNjktMTAuNzctNDAuMDMtMy42NS0xMy41NS03LjMxLTI3LjE1LTEyLjctNDAuMS0yMy44NC01Ny4zMy03Ny44Mi05NS4yNy0xMTkuMTMtMTQxLjYzLTI2LjQ2LTI5LjY5LTQ4LjAyLTYzLjM0LTY5LjQ2LTk2Ljg0LTIuMDUtMy4yLTQuMDktNi43Mi01LjUxLTEwLjMyLTUuMzEsMi42NC0xMC4wNyw2LjU4LTEzLjU5LDExLjU3LTYuNDEsOS4wOC03Ljg0LDE5Ljk4LTQuMDQsMzAuNjksMy4zNiw5LjQ1LDEzLjk1LDI2Ljg1LDI3LDQ2Ljg2LDYwLjg3LDM5LjEzLDEyNS4xMSw4Ni4xNiwxNDQuNSwxMTAuOSwyOC4xNiwzNS45NCw1My40LDEyMi43Myw2NC45NiwxNjguMzEsMy4zMyw1LjA2LDYuMjMsMTAuNDcsOC43MywxNi4yNloiLz4KICAgIDxwYXRoIGNsYXNzPSJjbHMtMiIgZD0iTTU2Ni44OSw1MjAuOTdjLTEuMzYtMTQuNDgtMy4wMy0yOS4wOC03Ljg3LTQyLjc5LTQuMTQtMTEuNy0xMC41LTIyLjQ3LTE2Ljg1LTMzLjEzLTExLjI1LTE4Ljg5LTIzLjMxLTM4LjQ0LTQyLjA1LTQ5Ljk0LTI1LjAxLTE1LjM1LTU3LjcyLTEzLjE1LTg0LjY5LTEuNTgtMjYuOTcsMTEuNTctNDkuNDUsMzEuMzQtNzEuNDQsNTAuNzgtMjAuMDgsMTcuNzYtNDAuMTYsMzUuNTEtNjAuMjUsNTMuMjctNy43Niw2Ljg2LTE2LjI2LDEzLjk0LTI1LjM3LDE4Ljk2LjY4Ljg2LDEuMzIsMS43NywyLjA0LDIuNTgsNy4zMiw4LjI5LDE1Ljg1LDEyLjg2LDI0LjAxLDEyLjg2aDBjMS40MSwwLDIuODMtLjEzLDQuMjItLjM5LDkuODgtMS44NSwzMi41OS0xOS44Myw1Ni42My0zOC44NSw0MS44NS0zMy4xMyw4OS42OS03MC44OSwxMTguOC02Ny40NiwxNi4xNiwxLjg3LDMyLjY3LDE1Ljk1LDQ2LjUsMzkuNjcsMjAuODEsMzUuNywzNC44Niw5NC4xMywyMS4yNiwxMjYuMjctMTYuNSwzOS0zOS40MSw3NS4wOS05NC44OCw3NS4wOS04Ljc3LDAtMTguMzItLjk0LTI4LjM5LTIuNzMsMTMuMDUsNi4zNywyNy42NCw5LjE5LDQyLjE1LDEwLjM3LDI4LjgxLDIuMzQsNTkuNy0yLjA1LDgyLjEtMjAuMywxOC40Ni0xNS4wNSwyOS4xNC0zOC4wMywzMy40Ni02MS40Niw0LjMyLTIzLjQyLDIuODMtNDcuNS42MS03MS4yMloiLz4KICAgIDxwYXRoIGNsYXNzPSJjbHMtMiIgZD0iTTU2NC43Miw5NDYuODZjNDMuMywwLDExMS42Mi0yMC4xNSwxNjQuODgtNjQuMTQtMjIuNjIsNi44Mi00NS44NywxMS4zNi02OS40NiwxMy4wNi01OS4wMSw0LjI1LTEyMC4wMi05Ljc1LTE2OC41Mi00My42NC0xMy41Ny05LjQ4LTI2LjM1LTIwLjU3LTQxLjc3LTI2LjU5LTE4LjE2LTcuMS0zOC4zMy02LjUyLTU3LjM5LTEwLjYzLTQyLjA1LTkuMDctNzYuNDctNDAuODYtOTguMDUtNzguMDgtMjEuNTgtMzcuMjEtMzIuMDItNzkuNzEtNDEuMDEtMTIxLjc4LTQuNjMtMjEuNjctOC43NC00NS4xNC0uNTItNjUuNDctMy44NCwyLjEyLTYuOTgsNS42Mi04LjI1LDExLjMyLTYuODEsMzAuNjQtOC4zLDk4LjQ0LDE1LjQ5LDE1OS42NCwyNS44Niw2Ni41LDc2LjksMTE0LjUxLDE0My43MywxMzUuMiwzOS41MSwxMi4yMyw2MS43LDMzLjUsODEuMjcsNTIuMjYsMTcuMzgsMTYuNjYsMzIuMzksMzEuMDUsNTYuMDYsMzYuNTEsNi43OCwxLjU3LDE0LjcsMi4zNiwyMy41MywyLjM2WiIvPgogIDwvZz4KPC9zdmc+';

  // Add settings menu to the admin dashboard.
  add_menu_page(
      'CleanDesk AI',
      'CleanDesk AI',
      'manage_options',
      'cleandesk-ai',
      'cdaiw_settings_page',
      'data:image/svg+xml;base64,' . $base64_icon,
      20
  );
}

add_action('admin_menu', 'cdaiw_admin_menu');

// Register plugin settings.
function cdaiw_register_settings() {
  register_setting('cleandesk-widget-settings-group', 'cdaiw_app_id');
  register_setting('cleandesk-widget-settings-group', 'cdaiw_app_secret');
}

add_action('admin_init', 'cdaiw_register_settings');

// Create the settings page.
function cdaiw_settings_page() {
    ?>
<div class="wrap">
  <div class="cleandesk-widget-header">
    <div class="cleandesk-widget-header-top">
      <div class="cleandesk-widget-header-left">
        <a href="https://www.cleandesk.ai" target="_blank">
          <img src=<?php echo plugins_url( 'assets/images/logo96tranparent.png', __FILE__ ); ?> alt="Cleandesk Logo" class="cleandesk-logo" />
          <!-- <img src="https://www.cleandesk.ai/logo96tranparent.png" alt="Cleandesk Logo" class="cleandesk-logo" /> -->
        </a>
        <h1>CleanDesk AI Settings</h1>
      </div>
    </div>
    <div class="cleandesk-widget-header-bottom">
      <p>CleanDesk AI enables you to set up a Conversational AI Assistant on your webpage for lead generation, sales, support, and marketing. Utilize CARMA for lead generation and sales, and MAGICS for a comprehensive package that includes customer support.</p>

      <p>For more settings information, refer to the <a href="https://docs.cleandesk.ai/" target="_blank">documentation manual</a>.</p>
    </div>
  </div>

  <div class="cleandesk-ai-settings-body">
    <form method="post" action="options.php">
      <?php settings_fields('cleandesk-widget-settings-group'); ?>
      <?php do_settings_sections('cleandesk-widget-settings-group'); ?>

      <table class="form-table">
        <tr valign="top">
          <th scope="row">App ID:</th>
          <td>
            <input type="text" name="cdaiw_app_id"
              value="<?php echo esc_attr(get_option('cdaiw_app_id', '')); ?>"
              placeholder="Enter your Cleandesk App ID"
              autocomplete="off"
            />
          </td>
        </tr>
        <tr valign="top">
          <th scope="row">App Secret:</th>
          <td>
            <?php
              $appSecretValue = get_option('cdaiw_app_secret', '');
              $maskedAppSecret = !empty($appSecretValue) ? '*********************************' : '';
            ?>
            <input type="text" name="cdaiw_app_secret"
              value="<?php echo esc_attr($maskedAppSecret); ?>"
              placeholder="Enter your Cleandesk App Secret"
              autocomplete="off"
            />
          </td>
        </tr>
      </table>

      <?php submit_button('Save Changes', 'primary', 'submit-btn', false, array('style' => 'background-color: #0000ff; color: white; padding: 4px 8px; font-size: 14px; border: none;')); ?>

    </form>
  </div>
</div>
<style>
  .cleandesk-widget-header {
    background-color: #fff;
    border-bottom: 1px solid #e7e7e7;
    padding: 24px 36px;
    margin-bottom: 20px;
  }

  .cleandesk-logo {
    width: 48px;
    height: 48px;
    margin-right: 8px;
  }

  .cleandesk-widget-header-top {
    display: flex;
    justify-content: space-between;
    align-items: center;
  }

  .cleandesk-widget-header-left {
    text-decoration: none;
    display: flex;
    align-items: center;
  }

  .cleandesk-widget-header-left a {
    text-decoration: none;
    display: flex;
    align-items: center;
  }

  .cleandesk-ai-settings-body {
    padding: 0 24px;
  }

  .wrap {
    margin: 0px;
  }

  #wpcontent {
    padding-left: 0;
  }
</style>
<?php
}

add_filter('plugin_action_links', 'cdaiw_configure_link', 10, 2);

function cdaiw_configure_link($links, $file) {
  // Check if the plugin is the one you want to add the link to
  if (plugin_basename(__FILE__) == $file) {
      // Add the "Configure" link
      $configure_link = '<a href="' . admin_url('admin.php?page=cleandesk-ai') . '">Configure</a>';
      array_unshift($links, $configure_link);
  }

  return $links;
}

function cdaiw_disable_screen_options() {
  echo '<style>#screen-options-link-wrap { display: none !important; }</style>';
}

add_action('admin_head', 'cdaiw_disable_screen_options');

?>