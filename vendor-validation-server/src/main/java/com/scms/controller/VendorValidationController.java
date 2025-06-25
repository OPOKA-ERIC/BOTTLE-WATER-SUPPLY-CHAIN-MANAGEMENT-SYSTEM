package com.scms.controller;

import com.scms.model.VendorApplication;
import com.scms.service.VendorValidationService;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.http.ResponseEntity;
import org.springframework.web.bind.annotation.*;
import org.springframework.web.multipart.MultipartFile;

import java.util.HashMap;
import java.util.Map;

@RestController
@RequestMapping("/api/vendor-validation")
@CrossOrigin(origins = "*")
public class VendorValidationController {

    @Autowired
    private VendorValidationService validationService;

    @PostMapping("/validate")
    public ResponseEntity<Map<String, Object>> validateVendorApplication(
            @RequestParam("pdfFile") MultipartFile pdfFile,
            @RequestParam("businessName") String businessName,
            @RequestParam("businessType") String businessType,
            @RequestParam("description") String description) {

        try {
            // Create vendor application object
            VendorApplication application = new VendorApplication();
            application.setBusinessName(businessName);
            application.setBusinessType(businessType);
            application.setDescription(description);
            application.setStatus("pending");

            // Validate the application
            VendorApplication validatedApplication = validationService.validateVendorApplication(pdfFile, application);

            // Prepare application map for response
            Map<String, Object> appMap = new HashMap<>();
            appMap.put("status", validatedApplication.getStatus());
            appMap.put("rejectionReason", validatedApplication.getRejectionReason());
            appMap.put("overallScore", validatedApplication.getOverallScore());
            appMap.put("financialScore", validatedApplication.getFinancialScore());
            appMap.put("reputationScore", validatedApplication.getReputationScore());
            appMap.put("complianceScore", validatedApplication.getComplianceScore());
            appMap.put("scheduledVisitDate", validatedApplication.getScheduledVisitDate());
            appMap.put("visitStatus", validatedApplication.getVisitStatus());
            // Add more fields as needed

            Map<String, Object> response = new HashMap<>();
            response.put("success", true);
            response.put("application", appMap);
            response.put("message", "Vendor application validated successfully");

            return ResponseEntity.ok(response);

        } catch (Exception e) {
            Map<String, Object> response = new HashMap<>();
            response.put("success", false);
            response.put("message", "Error during validation: " + e.getMessage());
            return ResponseEntity.badRequest().body(response);
        }
    }

    @GetMapping("/status/{applicationId}")
    public ResponseEntity<Map<String, Object>> getApplicationStatus(@PathVariable Long applicationId) {
        // This would typically fetch from database
        // For now, return a mock response
        Map<String, Object> response = new HashMap<>();
        response.put("success", true);
        response.put("applicationId", applicationId);
        response.put("status", "pending");
        response.put("message", "Application status retrieved successfully");
        
        return ResponseEntity.ok(response);
    }

    @PostMapping("/visit-result")
    public ResponseEntity<Map<String, Object>> submitVisitResult(
            @RequestParam("applicationId") Long applicationId,
            @RequestParam("visitPassed") Boolean visitPassed,
            @RequestParam("visitNotes") String visitNotes) {

        try {
            // This would typically update the database
            // For now, return a mock response
            Map<String, Object> response = new HashMap<>();
            response.put("success", true);
            response.put("applicationId", applicationId);
            response.put("visitPassed", visitPassed);
            response.put("visitNotes", visitNotes);
            response.put("message", "Visit result submitted successfully");

            return ResponseEntity.ok(response);

        } catch (Exception e) {
            Map<String, Object> response = new HashMap<>();
            response.put("success", false);
            response.put("message", "Error submitting visit result: " + e.getMessage());
            return ResponseEntity.badRequest().body(response);
        }
    }

    @GetMapping("/health")
    public ResponseEntity<Map<String, Object>> healthCheck() {
        Map<String, Object> response = new HashMap<>();
        response.put("status", "UP");
        response.put("service", "Vendor Validation Service");
        response.put("timestamp", System.currentTimeMillis());
        
        return ResponseEntity.ok(response);
    }
} 