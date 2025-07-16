package com.scms.service;

import com.scms.model.VendorApplication;
import org.apache.pdfbox.pdmodel.PDDocument;
import org.apache.pdfbox.text.PDFTextStripper;
import org.springframework.stereotype.Service;
import org.springframework.web.multipart.MultipartFile;

import java.io.File;
import java.io.IOException;
import java.time.LocalDateTime;
import java.util.regex.Matcher;
import java.util.regex.Pattern;

@Service
public class VendorValidationService {

    private static final String UPLOAD_DIR = "uploads/";
    private static final double FINANCIAL_WEIGHT = 0.35;
    private static final double REPUTATION_WEIGHT = 0.30;
    private static final double COMPLIANCE_WEIGHT = 0.35;

    public VendorApplication validateVendorApplication(MultipartFile pdfFile, VendorApplication application) {
        System.out.println("=== STARTING VENDOR VALIDATION ===");
        System.out.println("PDF File Name: " + pdfFile.getOriginalFilename());
        System.out.println("PDF File Size: " + pdfFile.getSize() + " bytes");
        
        try {
            // Save PDF file
            String pdfPath = savePdfFile(pdfFile);
            System.out.println("PDF saved to: " + pdfPath);
            application.setPdfDocumentPath(pdfPath);
            application.setSubmittedAt(LocalDateTime.now());

            // Extract data from PDF
            System.out.println("Starting PDF text extraction...");
            extractDataFromPdf(pdfPath, application);
            System.out.println("PDF text extraction completed.");

            // Perform validation
            System.out.println("Starting validation...");
            performValidation(application);
            System.out.println("Validation completed. Status: " + application.getStatus());

            // Schedule facility visit if validation passes
            if (application.getOverallScore() != null && application.getOverallScore() >= 70.0) {
                System.out.println("Scheduling facility visit...");
                scheduleFacilityVisit(application);
            }

            application.setValidatedAt(LocalDateTime.now());
            System.out.println("=== VENDOR VALIDATION COMPLETED ===");
            return application;

        } catch (Exception e) {
            System.out.println("ERROR during validation: " + e.getMessage());
            e.printStackTrace();
            application.setStatus("rejected");
            application.setRejectionReason("Error during validation: " + e.getMessage());
            return application;
        }
    }

    private String savePdfFile(MultipartFile file) throws IOException {
        File uploadDir = new File(UPLOAD_DIR);
        if (!uploadDir.exists()) {
            uploadDir.mkdirs();
        }

        String fileName = System.currentTimeMillis() + "_" + file.getOriginalFilename();
        String filePath = UPLOAD_DIR + fileName;
        File dest = new File(filePath);
        file.transferTo(dest);
        return filePath;
    }

    private void extractDataFromPdf(String pdfPath, VendorApplication application) {
        System.out.println("=== EXTRACTING DATA FROM PDF ===");
        System.out.println("PDF Path: " + pdfPath);
        
        try (PDDocument document = PDDocument.load(new File(pdfPath))) {
            PDFTextStripper stripper = new PDFTextStripper();
            String text = stripper.getText(document);
            
            System.out.println("Extracted text length: " + text.length());
            System.out.println("First 500 characters of extracted text:");
            System.out.println(text.substring(0, Math.min(500, text.length())));
            
            if (text.trim().isEmpty()) {
                System.out.println("WARNING: No text extracted from PDF!");
                application.setRejectionReason("Unable to extract text from PDF document");
                return;
            }

            // Extract financial data
            System.out.println("Extracting financial data...");
            extractFinancialData(text, application);

            // Extract reputation data
            System.out.println("Extracting reputation data...");
            extractReputationData(text, application);

            // Extract compliance data
            System.out.println("Extracting compliance data...");
            extractComplianceData(text, application);
            
            System.out.println("=== DATA EXTRACTION COMPLETED ===");
            
        } catch (Exception e) {
            System.out.println("ERROR extracting data from PDF: " + e.getMessage());
            e.printStackTrace();
            application.setRejectionReason("Error extracting data from PDF: " + e.getMessage());
        }
    }

    private void extractFinancialData(String text, VendorApplication application) {
        System.out.println("=== EXTRACTING FINANCIAL DATA ===");
        
        // Extract annual revenue
        Pattern revenuePattern = Pattern.compile("(?i)annual\\s+revenue[\\s:]*\\$?([\\d,]+(?:\\.\\d{2})?)");
        Matcher revenueMatcher = revenuePattern.matcher(text);
        if (revenueMatcher.find()) {
            String revenueStr = revenueMatcher.group(1).replace(",", "");
            application.setAnnualRevenue(Double.parseDouble(revenueStr));
            System.out.println("Found Annual Revenue: " + application.getAnnualRevenue());
        } else {
            System.out.println("NO ANNUAL REVENUE FOUND");
        }

        // Extract net worth
        Pattern netWorthPattern = Pattern.compile("(?i)net\\s+worth[\\s:]*\\$?([\\d,]+(?:\\.\\d{2})?)");
        Matcher netWorthMatcher = netWorthPattern.matcher(text);
        if (netWorthMatcher.find()) {
            String netWorthStr = netWorthMatcher.group(1).replace(",", "");
            application.setNetWorth(Double.parseDouble(netWorthStr));
            System.out.println("Found Net Worth: " + application.getNetWorth());
        } else {
            System.out.println("NO NET WORTH FOUND");
        }

        // Extract years in business
        Pattern yearsPattern = Pattern.compile("(?i)(\\d+)\\s+years?\\s+in\\s+business");
        Matcher yearsMatcher = yearsPattern.matcher(text);
        if (yearsMatcher.find()) {
            application.setYearsInBusiness(Integer.parseInt(yearsMatcher.group(1)));
            System.out.println("Found Years in Business: " + application.getYearsInBusiness());
        } else {
            System.out.println("NO YEARS IN BUSINESS FOUND");
        }

        // Extract credit rating
        Pattern creditPattern = Pattern.compile("(?i)credit\\s+rating[\\s:]*([A-Z][+-]?)");
        Matcher creditMatcher = creditPattern.matcher(text);
        if (creditMatcher.find()) {
            application.setCreditRating(creditMatcher.group(1));
            System.out.println("Found Credit Rating: " + application.getCreditRating());
        } else {
            System.out.println("NO CREDIT RATING FOUND");
        }

        // Check for bankruptcy
        application.setHasBankruptcy(text.toLowerCase().contains("bankruptcy"));
        System.out.println("Has Bankruptcy: " + application.getHasBankruptcy());

        // Check for tax liens
        application.setHasTaxLiens(text.toLowerCase().contains("tax lien"));
        System.out.println("Has Tax Liens: " + application.getHasTaxLiens());
        
        System.out.println("=== FINANCIAL DATA EXTRACTION COMPLETE ===");
    }

    private void extractReputationData(String text, VendorApplication application) {
        // Extract average rating
        Pattern ratingPattern = Pattern.compile("(?i)rating[\\s:]*([\\d.]+)\\s*out\\s*of\\s*5");
        Matcher ratingMatcher = ratingPattern.matcher(text);
        if (ratingMatcher.find()) {
            application.setAverageRating(Double.parseDouble(ratingMatcher.group(1)));
        }

        // Extract total reviews
        Pattern reviewsPattern = Pattern.compile("(?i)(\\d+)\\s+reviews?");
        Matcher reviewsMatcher = reviewsPattern.matcher(text);
        if (reviewsMatcher.find()) {
            application.setTotalReviews(Integer.parseInt(reviewsMatcher.group(1)));
        }

        // Check for legal issues
        application.setHasLegalIssues(text.toLowerCase().contains("legal issue") || 
                                     text.toLowerCase().contains("lawsuit") ||
                                     text.toLowerCase().contains("litigation"));

        // Check for complaints
        application.setHasComplaints(text.toLowerCase().contains("complaint") ||
                                   text.toLowerCase().contains("dispute"));
    }

    private void extractComplianceData(String text, VendorApplication application) {
        System.out.println("=== EXTRACTING COMPLIANCE DATA ===");
        
        // Check for business license
        boolean hasBusinessLicense = text.toLowerCase().contains("business license") ||
                                   text.toLowerCase().contains("operating license");
        application.setHasBusinessLicense(hasBusinessLicense);
        System.out.println("Has Business License: " + hasBusinessLicense);

        // Check for tax registration
        boolean hasTaxRegistration = text.toLowerCase().contains("tax registration") ||
                                         text.toLowerCase().contains("tax id") ||
                                   text.toLowerCase().contains("ein");
        application.setHasTaxRegistration(hasTaxRegistration);
        System.out.println("Has Tax Registration: " + hasTaxRegistration);

        // Check for insurance
        boolean hasInsurance = text.toLowerCase().contains("insurance") ||
                             text.toLowerCase().contains("liability coverage");
        application.setHasInsurance(hasInsurance);
        System.out.println("Has Insurance: " + hasInsurance);

        // Check for environmental compliance
        boolean hasEnvironmentalCompliance = text.toLowerCase().contains("environmental") ||
                                                 text.toLowerCase().contains("epa") ||
                                           text.toLowerCase().contains("green");
        application.setHasEnvironmentalCompliance(hasEnvironmentalCompliance);
        System.out.println("Has Environmental Compliance: " + hasEnvironmentalCompliance);

        // Check for safety certification
        boolean hasSafetyCertification = text.toLowerCase().contains("safety") ||
                                             text.toLowerCase().contains("osha") ||
                                       text.toLowerCase().contains("certification") ||
                                       text.toLowerCase().contains("safety excellence") ||
                                       text.toLowerCase().contains("ohsas") ||
                                       text.toLowerCase().contains("occupational health");
        application.setHasSafetyCertification(hasSafetyCertification);
        System.out.println("Has Safety Certification: " + hasSafetyCertification);
        
        System.out.println("=== COMPLIANCE DATA EXTRACTION COMPLETE ===");
    }

    private void performValidation(VendorApplication application) {
        StringBuilder rejectionReasons = new StringBuilder();
        boolean passed = true;

        // Log extracted data for debugging
        System.out.println("=== VALIDATION DEBUG ===");
        System.out.println("Annual Revenue: " + application.getAnnualRevenue());
        System.out.println("Net Worth: " + application.getNetWorth());
        System.out.println("Years in Business: " + application.getYearsInBusiness());
        System.out.println("Has Business License: " + application.getHasBusinessLicense());
        System.out.println("Has Tax Registration: " + application.getHasTaxRegistration());
        System.out.println("Has Insurance: " + application.getHasInsurance());
        System.out.println("Has Environmental Compliance: " + application.getHasEnvironmentalCompliance());
        System.out.println("Has Safety Certification: " + application.getHasSafetyCertification());
        System.out.println("Has Legal Issues: " + application.getHasLegalIssues());
        System.out.println("Has Complaints: " + application.getHasComplaints());
        System.out.println("========================");

        // Financial stability
        if (application.getAnnualRevenue() == null || application.getAnnualRevenue() < 10000000) {
            rejectionReasons.append("Annual revenue must be at least 10,000,000. ");
            passed = false;
        }
        if (application.getNetWorth() == null || application.getNetWorth() < 100000000) {
            rejectionReasons.append("Net worth must be at least 100,000,000. ");
            passed = false;
        }
        if (application.getYearsInBusiness() == null || application.getYearsInBusiness() < 5) {
            rejectionReasons.append("Years in business must be at least 5. ");
            passed = false;
        }

        // Reputation
        if (Boolean.TRUE.equals(application.getHasLegalIssues())) {
            rejectionReasons.append("There must be no legal issues. ");
            passed = false;
        }
        if (Boolean.TRUE.equals(application.getHasComplaints())) {
            rejectionReasons.append("There must be no complaints. ");
            passed = false;
        }

        // Regulatory compliance
        if (!Boolean.TRUE.equals(application.getHasBusinessLicense())) {
            rejectionReasons.append("Business license is required. ");
            passed = false;
        }
        if (!Boolean.TRUE.equals(application.getHasTaxRegistration())) {
            rejectionReasons.append("Tax registration is required. ");
            passed = false;
        }
        if (!Boolean.TRUE.equals(application.getHasInsurance())) {
            rejectionReasons.append("Insurance is required. ");
            passed = false;
        }
        if (!Boolean.TRUE.equals(application.getHasEnvironmentalCompliance())) {
            rejectionReasons.append("Environmental compliance is required. ");
            passed = false;
        }
        if (!Boolean.TRUE.equals(application.getHasSafetyCertification())) {
            rejectionReasons.append("Safety certification is required. ");
            passed = false;
        }

        if (passed) {
            application.setStatus("approved");
            application.setRejectionReason(null);
        } else {
            application.setStatus("rejected");
            application.setRejectionReason(rejectionReasons.toString().trim());
        }
    }

    private double calculateFinancialScore(VendorApplication application) {
        double score = 0.0;

        // Annual revenue scoring (0-25 points)
        if (application.getAnnualRevenue() != null) {
            if (application.getAnnualRevenue() >= 1000000) score += 25;
            else if (application.getAnnualRevenue() >= 500000) score += 20;
            else if (application.getAnnualRevenue() >= 250000) score += 15;
            else if (application.getAnnualRevenue() >= 100000) score += 10;
            else score += 5;
        }

        // Net worth scoring (0-20 points)
        if (application.getNetWorth() != null) {
            if (application.getNetWorth() >= 500000) score += 20;
            else if (application.getNetWorth() >= 250000) score += 15;
            else if (application.getNetWorth() >= 100000) score += 10;
            else score += 5;
        }

        // Years in business scoring (0-15 points)
        if (application.getYearsInBusiness() != null) {
            if (application.getYearsInBusiness() >= 10) score += 15;
            else if (application.getYearsInBusiness() >= 5) score += 12;
            else if (application.getYearsInBusiness() >= 3) score += 8;
            else score += 5;
        }

        // Credit rating scoring (0-20 points)
        if (application.getCreditRating() != null) {
            switch (application.getCreditRating().toUpperCase()) {
                case "A+":
                case "A":
                    score += 20;
                    break;
                case "A-":
                case "B+":
                    score += 15;
                    break;
                case "B":
                case "B-":
                    score += 10;
                    break;
                case "C+":
                case "C":
                    score += 5;
                    break;
                default:
                    score += 0;
            }
        }

        // Penalties
        if (Boolean.TRUE.equals(application.getHasBankruptcy())) score -= 20;
        if (Boolean.TRUE.equals(application.getHasTaxLiens())) score -= 15;

        return Math.max(0, Math.min(100, score));
    }

    private double calculateReputationScore(VendorApplication application) {
        double score = 0.0;

        // Average rating scoring (0-30 points)
        if (application.getAverageRating() != null) {
            if (application.getAverageRating() >= 4.5) score += 30;
            else if (application.getAverageRating() >= 4.0) score += 25;
            else if (application.getAverageRating() >= 3.5) score += 20;
            else if (application.getAverageRating() >= 3.0) score += 15;
            else score += 10;
        }

        // Total reviews scoring (0-20 points)
        if (application.getTotalReviews() != null) {
            if (application.getTotalReviews() >= 100) score += 20;
            else if (application.getTotalReviews() >= 50) score += 15;
            else if (application.getTotalReviews() >= 25) score += 10;
            else score += 5;
        }

        // Penalties
        if (Boolean.TRUE.equals(application.getHasLegalIssues())) score -= 25;
        if (Boolean.TRUE.equals(application.getHasComplaints())) score -= 15;

        return Math.max(0, Math.min(100, score));
    }

    private double calculateComplianceScore(VendorApplication application) {
        double score = 0.0;

        // Required compliance items (20 points each)
        if (Boolean.TRUE.equals(application.getHasBusinessLicense())) score += 20;
        if (Boolean.TRUE.equals(application.getHasTaxRegistration())) score += 20;
        if (Boolean.TRUE.equals(application.getHasInsurance())) score += 20;
        if (Boolean.TRUE.equals(application.getHasEnvironmentalCompliance())) score += 20;
        if (Boolean.TRUE.equals(application.getHasSafetyCertification())) score += 20;

        return Math.max(0, Math.min(100, score));
    }

    private void scheduleFacilityVisit(VendorApplication application) {
        // Schedule visit for 2 weeks from now
        LocalDateTime visitDate = LocalDateTime.now().plusWeeks(2);
        application.setScheduledVisitDate(visitDate);
        application.setVisitStatus("scheduled");
    }
} 