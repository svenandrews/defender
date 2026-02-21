# WAF-like Reverse Proxy

## Overview
This project implements a simple WAF-like reverse proxy in Node.js, aiming to provide basic protections for upstream servers.

## Features
- IP allow/deny lists
- Rate limiting
- Request size limits
- Path/method filtering
- Structured logging

## Setup
1. Clone the repository.
2. Run `npm install` to install the dependencies.
3. Configure environment variables for your upstream target, IP lists, and limits.

## Usage
```bash
node src/server.js
```

## Configuration
Environment variables:
- `UPSTREAM_TARGET`: The upstream server URL.
- `ALLOWED_IPS`: Comma-separated list of allowed IPs.
- `DENIED_IPS`: Comma-separated list of denied IPs.
- `RATE_LIMIT`: Maximum requests per minute.
- `REQUEST_SIZE_LIMIT`: Maximum request size in bytes.
