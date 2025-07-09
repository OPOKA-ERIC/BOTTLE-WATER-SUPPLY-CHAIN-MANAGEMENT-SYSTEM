# Vendor Validation Server

A Java Spring Boot application that validates vendor applications submitted via PDF documents. The server performs automated validation based on financial stability, reputation, and regulatory compliance criteria.

## Features

- **PDF Processing**: Extracts data from vendor application PDFs
- **Automated Validation**: Scores applications based on multiple criteria
- **Financial Stability Check**: Evaluates revenue, net worth, credit rating, etc.
- **Reputation Assessment**: Analyzes ratings, reviews, legal issues
- **Compliance Verification**: Checks licenses, insurance, certifications
- **Facility Visit Scheduling**: Automatically schedules visits for qualified applicants
- **REST API**: Provides endpoints for integration with other systems

## Validation Criteria

### Financial Stability (35% weight)
- Annual Revenue: $1M+ (25 pts), $500K+ (20 pts), $250K+ (15 pts), $100K+ (10 pts)
- Net Worth: $500K+ (20 pts), $250K+ (15 pts), $100K+ (10 pts)
- Years in Business: 10+ (15 pts), 5+ (12 pts), 3+ (8 pts)
- Credit Rating: A/A+ (20 pts), A-/B+ (15 pts), B/B- (10 pts), C+/C (5 pts)
- Penalties: Bankruptcy (-20 pts), Tax Liens (-15 pts)

### Reputation (30% weight)
- Average Rating: 4.5+ (30 pts), 4.0+ (25 pts), 3.5+ (20 pts), 3.0+ (15 pts)
- Total Reviews: 100+ (20 pts), 50+ (15 pts), 25+ (10 pts)
- Penalties: Legal Issues (-25 pts), Complaints (-15 pts)

### Regulatory Compliance (35% weight)
- Business License (20 pts)
- Tax Registration (20 pts)
- Insurance Coverage (20 pts)
- Environmental Compliance (20 pts)
- Safety Certification (20 pts)

## Scoring System

- **80+ points**: Auto-approved for facility visit
- **70-79 points**: Conditional approval
- **<70 points**: Rejected

## API Endpoints

### POST /api/vendor-validation/validate
Submit a vendor application for validation

**Parameters:**
- `pdfFile`: PDF document (multipart)
- `businessName`: String
- `businessType`: String
- `description`: String

**Response:**
```json
{
  "success": true,
  "application": {
    "id": 1,
    "businessName": "Example Corp",
    "status": "approved_for_visit",
    "overallScore": 85.5,
    "financialScore": 90.0,
    "reputationScore": 85.0,
    "complianceScore": 80.0,
    "scheduledVisitDate": "2024-01-15T10:00:00"
  },
  "message": "Vendor application validated successfully"
}
```

### GET /api/vendor-validation/status/{applicationId}
Get application status

### POST /api/vendor-validation/visit-result
Submit facility visit results

### GET /api/vendor-validation/health
Health check endpoint

## Running the Application

### Prerequisites
- Java 11 or higher
- Maven 3.6 or higher

### Build and Run
```bash
# Navigate to the project directory
cd vendor-validation-server

# Build the project
mvn clean install

# Run the application
mvn spring-boot:run
```

The server will start on `http://localhost:8081/vendor-validation`

### H2 Database Console
Access the H2 database console at: `http://localhost:8081/vendor-validation/h2-console`

**Connection Details:**
- JDBC URL: `jdbc:h2:mem:vendorvalidation`
- Username: `sa`
- Password: `password`

## PDF Format Requirements

The PDF should contain the following information in a readable format:

### Financial Information
- Annual Revenue: $X,XXX,XXX
- Net Worth: $X,XXX,XXX
- Years in Business: X years
- Credit Rating: A, B, C, etc.
- Bankruptcy history (if any)
- Tax lien information (if any)

### Reputation Information
- Average Rating: X.X out of 5
- Total Reviews: XXX
- Legal issues (if any)
- Customer complaints (if any)

### Compliance Information
- Business license status
- Tax registration status
- Insurance coverage details
- Environmental compliance status
- Safety certifications

## Recommended Document Template

```
VENDOR APPLICATION DOCUMENT
=====================================

COMPANY INFORMATION
-------------------
Business Name: [Company Name]
Business Type: [Type of Business]
Years in Business: [X] years
Business License: Yes - License #[Number]
Tax Registration: Yes - EIN: [Number]

FINANCIAL INFORMATION
---------------------
Annual Revenue: $[Amount] (minimum $10,000,000)
Net Worth: $[Amount] (minimum $100,000,000)
Credit Rating: [A+, A, B+, etc.]
Bankruptcy History: None
Tax Liens: None

REPUTATION & REVIEWS
-------------------
Average Rating: [X.X] out of 5
Total Reviews: [Number]
Legal Issues: None
Customer Complaints: None

COMPLIANCE & CERTIFICATIONS
--------------------------
Business License: Active - [Details]
Tax Registration: Current - [Details]
Insurance Coverage: [Type] - [Coverage amount]
Environmental Compliance: [EPA/Environmental details]
Safety Certification: [OSHA/Safety details] - [Certification name]

[Additional sections as needed]

DECLARATION
-----------
I, [Name], [Title] of [Company], hereby declare that all information provided in this document is true and accurate to the best of my knowledge.

Signature: _________________________
Date: _____________________________
Title: [Title]
```

## Validation Keywords

The system looks for these specific keywords:

### Financial Keywords:
- "annual revenue", "revenue", "annual income"
- "net worth", "net value", "total assets"
- "years in business", "established", "founded"
- "credit rating", "credit score", "rating"

### Compliance Keywords:
- "business license", "operating license", "license"
- "tax registration", "tax id", "ein", "employer identification"
- "insurance", "liability coverage", "coverage"
- "environmental", "epa", "green", "environmental compliance"
- "safety", "osha", "certification", "safety excellence", "ohsas", "occupational health"

### Reputation Keywords:
- "rating", "out of 5", "stars"
- "reviews", "customer reviews"
- "legal issue", "lawsuit", "litigation"
- "complaint", "dispute", "customer complaint"

## Integration with Laravel Application

The Java server is designed to integrate with the Laravel SCMS application. The Laravel application can:

1. Submit vendor applications to the Java server
2. Receive validation results
3. Schedule facility visits based on validation scores
4. Update application status based on visit results

## Configuration

Key configuration options in `application.properties`:

- `app.validation.financial-weight`: Weight for financial scoring (default: 0.35)
- `app.validation.reputation-weight`: Weight for reputation scoring (default: 0.30)
- `app.validation.compliance-weight`: Weight for compliance scoring (default: 0.35)
- `app.validation.minimum-score`: Minimum score for approval (default: 70.0)
- `app.validation.auto-approval-score`: Score for auto-approval (default: 80.0)

## Development

### Project Structure
```
src/main/java/com/scms/
├── VendorValidationApplication.java    # Main application class
├── controller/
│   └── VendorValidationController.java # REST API endpoints
├── model/
│   └── VendorApplication.java         # Data model
└── service/
    └── VendorValidationService.java   # Business logic
```

### Adding New Validation Rules

1. Update the `VendorApplication` model with new fields
2. Modify `VendorValidationService` to extract and validate new data
3. Update scoring algorithms in the service
4. Test with sample PDFs

## Testing

The application includes unit tests for the validation service. Run tests with:

```bash
mvn test
```

## Deployment

For production deployment:

1. Configure a production database (MySQL, PostgreSQL)
2. Update `application.properties` with production settings
3. Set up proper security configurations
4. Configure file storage for PDF uploads
5. Set up monitoring and logging 