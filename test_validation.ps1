# Test Vendor Validation API
$htmlContent = Get-Content "test_vendor_document.html" -Raw

# Create a simple test request
$testData = @{
    vendorName = "BRAD"
    businessName = "PureWater Solutions LLC"
    businessType = "Water Bottling and Distribution"
    businessDescription = "Premium bottled water production and distribution"
}

# Convert to JSON
$jsonData = $testData | ConvertTo-Json

Write-Host "Testing vendor validation API..."
Write-Host "JSON Data: $jsonData"
Write-Host "HTML Content length: $($htmlContent.Length)"

# Note: This is a test script to show what we're sending
# The actual validation would need a PDF file upload
Write-Host "To test with a real PDF, you would need to:"
Write-Host "1. Convert the HTML to PDF"
Write-Host "2. Upload the PDF file to the Laravel application"
Write-Host "3. The Laravel app will send it to the Java validation server" 