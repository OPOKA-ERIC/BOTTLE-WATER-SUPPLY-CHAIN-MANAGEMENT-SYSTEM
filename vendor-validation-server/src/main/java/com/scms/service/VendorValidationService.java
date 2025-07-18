package com.scms.service;

import com.scms.model.ValidationResult;
import org.apache.pdfbox.pdmodel.PDDocument;
import org.apache.pdfbox.text.PDFTextStripper;
import org.springframework.stereotype.Service;
import org.springframework.web.multipart.MultipartFile;

import java.io.InputStream;
import java.util.regex.*;

@Service
public class VendorValidationService {

    public ValidationResult validate(MultipartFile file) {
        boolean financial = false, reputation = false, regulatory = false;
        boolean scheduleVisit = false;
        String reason = null;

        String text = extractText(file);

        // Financial Stability
        Pattern revenuePattern = Pattern.compile("Revenue:\\s*UGX\\s*([\\d,]+)", Pattern.CASE_INSENSITIVE);
        Matcher revenueMatcher = revenuePattern.matcher(text);
        long revenue = 0;
        if (revenueMatcher.find()) {
            String revenueStr = revenueMatcher.group(1).replace(",", "");
            revenue = Long.parseLong(revenueStr);
            financial = revenue >= 100_000_000;
        }

        // Reputation
        boolean notBlacklisted = text.matches("(?s).*Blacklisted:\\s*No.*");
        Pattern disputesPattern = Pattern.compile("Disputes:\\s*(\\d+)", Pattern.CASE_INSENSITIVE);
        Matcher disputesMatcher = disputesPattern.matcher(text);
        int disputes = 0;
        if (disputesMatcher.find()) {
            disputes = Integer.parseInt(disputesMatcher.group(1));
        }
        reputation = notBlacklisted && disputes <= 2;

        // Regulatory Compliance
        boolean hasNema = text.matches("(?s).*NEMA License:\\s*\\S+.*");
        boolean hasUnbs = text.matches("(?s).*UNBS Certified:\\s*Yes.*");
        regulatory = hasNema && hasUnbs;

        // Decision
        if (financial && reputation && regulatory) {
            scheduleVisit = true;
            return new ValidationResult("APPROVED", true, true, true, scheduleVisit, null);
        } else {
            if (!financial) reason = "Vendor failed financial stability check";
            else if (!reputation) reason = "Vendor failed reputation check";
            else if (!regulatory) reason = "Vendor failed regulatory compliance check";
            return new ValidationResult("REJECTED", financial, reputation, regulatory, false, reason);
        }
    }

    private String extractText(MultipartFile file) {
        try (InputStream is = file.getInputStream(); PDDocument doc = PDDocument.load(is)) {
            return new PDFTextStripper().getText(doc);
        } catch (Exception e) {
            throw new RuntimeException("Failed to parse PDF: " + e.getMessage());
        }
    }
} 