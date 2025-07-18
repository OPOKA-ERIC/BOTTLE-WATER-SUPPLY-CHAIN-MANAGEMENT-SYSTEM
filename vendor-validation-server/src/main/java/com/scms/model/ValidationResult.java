package com.scms.model;

import java.util.HashMap;
import java.util.Map;

public class ValidationResult {
    private String status;
    private Map<String, Boolean> criteria = new HashMap<>();
    private Boolean scheduleVisit;
    private String reason;

    public ValidationResult() {}

    public ValidationResult(String status, boolean financial, boolean reputation, boolean regulatory, boolean scheduleVisit, String reason) {
        this.status = status;
        this.criteria.put("financial", financial);
        this.criteria.put("reputation", reputation);
        this.criteria.put("regulatory", regulatory);
        this.scheduleVisit = scheduleVisit;
        this.reason = reason;
    }

    // Getters and setters

    public String getStatus() { return status; }
    public void setStatus(String status) { this.status = status; }

    public Map<String, Boolean> getCriteria() { return criteria; }
    public void setCriteria(Map<String, Boolean> criteria) { this.criteria = criteria; }

    public Boolean getScheduleVisit() { return scheduleVisit; }
    public void setScheduleVisit(Boolean scheduleVisit) { this.scheduleVisit = scheduleVisit; }

    public String getReason() { return reason; }
    public void setReason(String reason) { this.reason = reason; }
} 