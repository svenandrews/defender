# Defender — FIM and File Checker

Defender is a WordPress plugin that provides simple **File Integrity Monitoring (FIM)** and file checking for your WordPress installation.

## Features

- **File Count Monitoring** — Tracks the total number of files in your WordPress installation over time and reports changes between scans.
- **File Integrity Checking** — Computes MD5 hashes of all files and detects when file contents have been modified.
- **Change Log** — Maintains a log of files that have changed, viewable from the WordPress admin panel.

## Installation

1. Copy the `defender` folder into your WordPress `wp-content/plugins/` directory.
2. Activate the plugin through the **Plugins** menu in WordPress.
3. The plugin will automatically create the required database tables on activation.

## Usage

Once activated, navigate to the **Defender** menu item in the WordPress admin sidebar.

- **FIM Check** — Runs a file count scan and logs the total number of files.
- **Adv Check** — Runs a full integrity check, hashing every file and flagging any that have changed since the last scan.

The dashboard displays:

- The date/time of the last scan
- The current file count
- File count changes since the previous scan
- The number of files being monitored
- A log of all detected file changes

## Requirements

- WordPress 4.0+
- PHP 7.0+
