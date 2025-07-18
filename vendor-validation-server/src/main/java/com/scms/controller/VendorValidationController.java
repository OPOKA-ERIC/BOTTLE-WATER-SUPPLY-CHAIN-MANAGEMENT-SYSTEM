package com.scms.controller;

import com.scms.model.ValidationResult;
import com.scms.service.VendorValidationService;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.http.*;
import org.springframework.web.bind.annotation.*;
import org.springframework.web.multipart.MultipartFile;

@RestController
@RequestMapping("/api/vendor")
@CrossOrigin(origins = "http://localhost:8000") // Adjust for your Laravel dev server
public class VendorValidationController {

    @Autowired
    private VendorValidationService validationService;

    @PostMapping("/validate")
    public ResponseEntity<ValidationResult> validateVendor(@RequestParam("file") MultipartFile file) {
        try {
            ValidationResult result = validationService.validate(file);
            if ("APPROVED".equals(result.getStatus())) {
                return ResponseEntity.ok(result);
            } else {
                return ResponseEntity.status(HttpStatus.BAD_REQUEST).body(result);
            }
        } catch (Exception e) {
            return ResponseEntity.status(HttpStatus.INTERNAL_SERVER_ERROR)
                    .body(new ValidationResult("REJECTED", false, false, false, false, "Server error: " + e.getMessage()));
        }
    }
} 