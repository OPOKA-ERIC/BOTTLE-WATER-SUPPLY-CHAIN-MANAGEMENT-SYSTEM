package com.scms;

import org.springframework.boot.SpringApplication;
import org.springframework.boot.autoconfigure.SpringBootApplication;
import org.springframework.scheduling.annotation.EnableScheduling;

@SpringBootApplication
@EnableScheduling
public class VendorValidationApplication {
    public static void main(String[] args) {
        SpringApplication.run(VendorValidationApplication.class, args);
    }
} 