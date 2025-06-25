package com.scms.model;

import javax.persistence.*;
import java.time.LocalDateTime;

@Entity
@Table(name = "vendor_applications")
public class VendorApplication {
    @Id
    @GeneratedValue(strategy = GenerationType.IDENTITY)
    private Long id;
    
    private String businessName;
    private String businessType;
    private String description;
    private String status;
    private String rejectionReason;
    
    // Financial Stability Data
    private Double annualRevenue;
    private Double netWorth;
    private Integer yearsInBusiness;
    private String creditRating;
    private Boolean hasBankruptcy;
    private Boolean hasTaxLiens;
    
    // Reputation Data
    private Double averageRating;
    private Integer totalReviews;
    private Boolean hasLegalIssues;
    private String legalIssuesDescription;
    private Boolean hasComplaints;
    private String complaintsDescription;
    
    // Regulatory Compliance Data
    private Boolean hasBusinessLicense;
    private Boolean hasTaxRegistration;
    private Boolean hasInsurance;
    private String insuranceType;
    private Boolean hasEnvironmentalCompliance;
    private Boolean hasSafetyCertification;
    
    // Facility Visit Data
    private LocalDateTime scheduledVisitDate;
    private String visitStatus;
    private String visitNotes;
    private Boolean visitPassed;
    
    // PDF Document Data
    private String pdfDocumentPath;
    private LocalDateTime submittedAt;
    private LocalDateTime validatedAt;
    
    // Validation Scores
    private Double financialScore;
    private Double reputationScore;
    private Double complianceScore;
    private Double overallScore;
    
    // Constructors
    public VendorApplication() {}
    
    // Getters and Setters
    public Long getId() { return id; }
    public void setId(Long id) { this.id = id; }
    
    public String getBusinessName() { return businessName; }
    public void setBusinessName(String businessName) { this.businessName = businessName; }
    
    public String getBusinessType() { return businessType; }
    public void setBusinessType(String businessType) { this.businessType = businessType; }
    
    public String getDescription() { return description; }
    public void setDescription(String description) { this.description = description; }
    
    public String getStatus() { return status; }
    public void setStatus(String status) { this.status = status; }
    
    public String getRejectionReason() { return rejectionReason; }
    public void setRejectionReason(String rejectionReason) { this.rejectionReason = rejectionReason; }
    
    public Double getAnnualRevenue() { return annualRevenue; }
    public void setAnnualRevenue(Double annualRevenue) { this.annualRevenue = annualRevenue; }
    
    public Double getNetWorth() { return netWorth; }
    public void setNetWorth(Double netWorth) { this.netWorth = netWorth; }
    
    public Integer getYearsInBusiness() { return yearsInBusiness; }
    public void setYearsInBusiness(Integer yearsInBusiness) { this.yearsInBusiness = yearsInBusiness; }
    
    public String getCreditRating() { return creditRating; }
    public void setCreditRating(String creditRating) { this.creditRating = creditRating; }
    
    public Boolean getHasBankruptcy() { return hasBankruptcy; }
    public void setHasBankruptcy(Boolean hasBankruptcy) { this.hasBankruptcy = hasBankruptcy; }
    
    public Boolean getHasTaxLiens() { return hasTaxLiens; }
    public void setHasTaxLiens(Boolean hasTaxLiens) { this.hasTaxLiens = hasTaxLiens; }
    
    public Double getAverageRating() { return averageRating; }
    public void setAverageRating(Double averageRating) { this.averageRating = averageRating; }
    
    public Integer getTotalReviews() { return totalReviews; }
    public void setTotalReviews(Integer totalReviews) { this.totalReviews = totalReviews; }
    
    public Boolean getHasLegalIssues() { return hasLegalIssues; }
    public void setHasLegalIssues(Boolean hasLegalIssues) { this.hasLegalIssues = hasLegalIssues; }
    
    public String getLegalIssuesDescription() { return legalIssuesDescription; }
    public void setLegalIssuesDescription(String legalIssuesDescription) { this.legalIssuesDescription = legalIssuesDescription; }
    
    public Boolean getHasComplaints() { return hasComplaints; }
    public void setHasComplaints(Boolean hasComplaints) { this.hasComplaints = hasComplaints; }
    
    public String getComplaintsDescription() { return complaintsDescription; }
    public void setComplaintsDescription(String complaintsDescription) { this.complaintsDescription = complaintsDescription; }
    
    public Boolean getHasBusinessLicense() { return hasBusinessLicense; }
    public void setHasBusinessLicense(Boolean hasBusinessLicense) { this.hasBusinessLicense = hasBusinessLicense; }
    
    public Boolean getHasTaxRegistration() { return hasTaxRegistration; }
    public void setHasTaxRegistration(Boolean hasTaxRegistration) { this.hasTaxRegistration = hasTaxRegistration; }
    
    public Boolean getHasInsurance() { return hasInsurance; }
    public void setHasInsurance(Boolean hasInsurance) { this.hasInsurance = hasInsurance; }
    
    public String getInsuranceType() { return insuranceType; }
    public void setInsuranceType(String insuranceType) { this.insuranceType = insuranceType; }
    
    public Boolean getHasEnvironmentalCompliance() { return hasEnvironmentalCompliance; }
    public void setHasEnvironmentalCompliance(Boolean hasEnvironmentalCompliance) { this.hasEnvironmentalCompliance = hasEnvironmentalCompliance; }
    
    public Boolean getHasSafetyCertification() { return hasSafetyCertification; }
    public void setHasSafetyCertification(Boolean hasSafetyCertification) { this.hasSafetyCertification = hasSafetyCertification; }
    
    public LocalDateTime getScheduledVisitDate() { return scheduledVisitDate; }
    public void setScheduledVisitDate(LocalDateTime scheduledVisitDate) { this.scheduledVisitDate = scheduledVisitDate; }
    
    public String getVisitStatus() { return visitStatus; }
    public void setVisitStatus(String visitStatus) { this.visitStatus = visitStatus; }
    
    public String getVisitNotes() { return visitNotes; }
    public void setVisitNotes(String visitNotes) { this.visitNotes = visitNotes; }
    
    public Boolean getVisitPassed() { return visitPassed; }
    public void setVisitPassed(Boolean visitPassed) { this.visitPassed = visitPassed; }
    
    public String getPdfDocumentPath() { return pdfDocumentPath; }
    public void setPdfDocumentPath(String pdfDocumentPath) { this.pdfDocumentPath = pdfDocumentPath; }
    
    public LocalDateTime getSubmittedAt() { return submittedAt; }
    public void setSubmittedAt(LocalDateTime submittedAt) { this.submittedAt = submittedAt; }
    
    public LocalDateTime getValidatedAt() { return validatedAt; }
    public void setValidatedAt(LocalDateTime validatedAt) { this.validatedAt = validatedAt; }
    
    public Double getFinancialScore() { return financialScore; }
    public void setFinancialScore(Double financialScore) { this.financialScore = financialScore; }
    
    public Double getReputationScore() { return reputationScore; }
    public void setReputationScore(Double reputationScore) { this.reputationScore = reputationScore; }
    
    public Double getComplianceScore() { return complianceScore; }
    public void setComplianceScore(Double complianceScore) { this.complianceScore = complianceScore; }
    
    public Double getOverallScore() { return overallScore; }
    public void setOverallScore(Double overallScore) { this.overallScore = overallScore; }
} 