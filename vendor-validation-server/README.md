# Vendor Validation Server (Java Microservice)

This is a Spring Boot microservice for validating vendor applications in PDF format based on financial stability, business reputation, and regulatory compliance.

## Features
- **Financial Stability:** Checks for minimum revenue (UGX 100,000,000)
- **Reputation:** Checks for blacklisting and number of disputes
- **Regulatory Compliance:** Checks for NEMA License and UNBS Certification
- **REST API:** Accepts PDF via HTTP POST, returns JSON result

## Setup

1. **Navigate to the directory:**
   ```sh
   cd vendor-validation-server
   ```
2. **Build and run:**
   ```sh
   mvn spring-boot:run
   ```
   The server will start on port 8081 by default.

## API Usage

- **Endpoint:** `POST /api/vendor/validate`
- **Form field:** `file` (PDF file)
- **Response:**
  - On success:
    ```json
    {
      "status": "APPROVED",
      "criteria": {
        "financial": true,
        "reputation": true,
        "regulatory": true
      },
      "scheduleVisit": true
    }
    ```
  - On failure:
    ```json
    {
      "status": "REJECTED",
      "criteria": {
        "financial": false,
        "reputation": true,
        "regulatory": true
      },
      "reason": "Vendor failed financial stability check"
    }
    ```

## CORS
- Allows requests from `http://localhost:8000` (Laravel dev server)

## Integration with Laravel
- Use Guzzle or Http::attach in Laravel to POST the PDF to this service.

--- 