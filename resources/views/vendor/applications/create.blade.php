@extends('layouts.app')

@section('content')
<div class="content">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header card-header-primary">
                        <h4 class="card-title">Submit Vendor Application</h4>
                        <p class="card-category">Fill in your business details and upload your application PDF</p>
                    </div>
                    <div class="card-body">
                        @if(session('success'))
                            <div class="alert alert-success">{{ session('success') }}</div>
                        @endif
                        @if(session('error'))
                            <div class="alert alert-danger">{{ session('error') }}</div>
                        @endif
                        @if($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <form method="POST" action="{{ route('vendor.applications.store') }}" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label for="business_name">Business Name</label>
                                <input type="text" name="business_name" id="business_name" class="form-control @error('business_name') is-invalid @enderror" value="{{ old('business_name') }}" required>
                                @error('business_name')
                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="business_type">Business Type</label>
                                <input type="text" name="business_type" id="business_type" class="form-control @error('business_type') is-invalid @enderror" value="{{ old('business_type') }}" required>
                                @error('business_type')
                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="description">Business Description</label>
                                <textarea name="description" id="description" rows="4" class="form-control @error('description') is-invalid @enderror" required>{{ old('description') }}</textarea>
                                @error('description')
                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="pdf_file">Application PDF <span class="text-danger">*</span></label>
                                <div class="pdf-upload-container">
                                <input type="file" name="pdf_file" id="pdf_file" class="form-control-file @error('pdf_file') is-invalid @enderror" accept="application/pdf" required>
                                    <div class="pdf-upload-info">
                                        <i class="nc-icon nc-paper"></i>
                                        <p class="upload-text">Upload your business documentation in PDF format</p>
                                        <p class="upload-requirements">
                                            <strong>Required Information:</strong><br>
                                            • Financial statements and revenue data<br>
                                            • Business license and compliance certificates<br>
                                            • Insurance and safety documentation<br>
                                            • Years in business and credit rating<br>
                                            • Any legal issues or complaints history
                                        </p>
                                        <p class="upload-note">Maximum file size: 10MB | Format: PDF only</p>
                                    </div>
                                </div>
                                @error('pdf_file')
                                    <span class="invalid-feedback d-block" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                                <small class="form-text text-muted">
                                    <strong>Note:</strong> This PDF document is mandatory for vendor validation. 
                                    The document will be automatically analyzed for compliance and financial verification.
                                </small>
                            </div>
                            <button type="submit" class="btn btn-primary">Submit Application</button>
                            <a href="{{ route('vendor.dashboard') }}" class="btn btn-secondary">Cancel</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* Content spacing to account for fixed navbar - increased padding with higher specificity */
body .content,
.wrapper .content,
.main-panel .content {
    padding-top: 140px !important;
    margin-top: 0 !important;
    min-height: calc(100vh - 140px) !important;
}

/* Ensure proper spacing for the main container */
.container-fluid {
    padding: 0 30px !important;
    max-width: 1400px !important;
    margin: 0 auto !important;
}

/* Card styling improvements */
.card {
    border-radius: 20px !important;
    box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1) !important;
    border: 1px solid rgba(255, 255, 255, 0.2) !important;
    overflow: hidden !important;
}

.card-header-primary {
    background: linear-gradient(135deg, rgba(25, 118, 210, 0.95) 0%, rgba(13, 71, 161, 0.95) 100%) !important;
    color: white !important;
    padding: 25px 30px !important;
    border-bottom: none !important;
}

.card-title {
    font-size: 1.5rem !important;
    font-weight: 700 !important;
    margin: 0 0 5px 0 !important;
    line-height: 1.2 !important;
}

.card-category {
    font-size: 0.95rem !important;
    margin: 0 !important;
    opacity: 0.9 !important;
    font-weight: 400 !important;
}

.card-body {
    padding: 30px !important;
    background: rgba(255, 255, 255, 0.95) !important;
}

/* Form styling improvements */
.form-group {
    margin-bottom: 25px !important;
}

.form-group label {
    font-weight: 600 !important;
    color: #333 !important;
    margin-bottom: 8px !important;
    display: block !important;
}

.form-control {
    border-radius: 12px !important;
    border: 1px solid rgba(0, 0, 0, 0.1) !important;
    padding: 12px 16px !important;
    font-size: 1rem !important;
    transition: all 0.3s ease !important;
}

.form-control:focus {
    border-color: #1976d2 !important;
    box-shadow: 0 0 0 0.2rem rgba(25, 118, 210, 0.25) !important;
}

.form-control-file {
    border: 2px dashed rgba(25, 118, 210, 0.3) !important;
    border-radius: 12px !important;
    padding: 20px !important;
    text-align: center !important;
    background: rgba(25, 118, 210, 0.05) !important;
    transition: all 0.3s ease !important;
}

.form-control-file:hover {
    border-color: #1976d2 !important;
    background: rgba(25, 118, 210, 0.1) !important;
}

/* Button styling improvements */
.btn {
    border-radius: 12px !important;
    padding: 12px 24px !important;
    font-weight: 600 !important;
    font-size: 1rem !important;
    transition: all 0.3s ease !important;
    border: none !important;
}

.btn-primary {
    background: linear-gradient(135deg, #667eea, #764ba2) !important;
    color: white !important;
}

.btn-primary:hover {
    transform: translateY(-2px) !important;
    box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4) !important;
    color: white !important;
}

.btn-secondary {
    background: rgba(108, 117, 125, 0.1) !important;
    color: #6c757d !important;
    border: 1px solid rgba(108, 117, 125, 0.3) !important;
}

.btn-secondary:hover {
    background: rgba(108, 117, 125, 0.2) !important;
    color: #6c757d !important;
    transform: translateY(-2px) !important;
}

/* Alert styling improvements */
.alert {
    border-radius: 12px !important;
    border: none !important;
    padding: 15px 20px !important;
    margin-bottom: 25px !important;
}

.alert-success {
    background: rgba(46, 125, 50, 0.1) !important;
    color: #2e7d32 !important;
    border-left: 4px solid #2e7d32 !important;
}

.alert-danger {
    background: rgba(211, 47, 47, 0.1) !important;
    color: #d32f2f !important;
    border-left: 4px solid #d32f2f !important;
}

/* Responsive Design */
@media (max-width: 768px) {
    body .content,
    .wrapper .content,
    .main-panel .content {
        padding-top: 160px !important;
    }
    
    .container-fluid {
        padding: 0 15px !important;
    }
    
    .card-header-primary {
        padding: 20px 20px !important;
    }
    
    .card-body {
        padding: 20px !important;
    }
    
    .btn {
        width: 100% !important;
        margin-bottom: 10px !important;
    }
}

/* Additional spacing for smaller screens */
@media (max-width: 576px) {
    body .content,
    .wrapper .content,
    .main-panel .content {
        padding-top: 180px !important;
    }
    
    .card-header-primary {
        padding: 15px 15px !important;
    }
    
    .card-body {
        padding: 15px !important;
    }
}

/* Force override any conflicting styles */
.content {
    padding-top: 140px !important;
    margin-top: 0 !important;
}

@media (max-width: 768px) {
    .content {
        padding-top: 160px !important;
    }
}

@media (max-width: 576px) {
    .content {
        padding-top: 180px !important;
    }
}

/* PDF Upload styling improvements */
.pdf-upload-container {
    border: 2px dashed rgba(25, 118, 210, 0.3) !important;
    border-radius: 12px !important;
    padding: 25px !important;
    text-align: center !important;
    background: rgba(25, 118, 210, 0.05) !important;
    transition: all 0.3s ease !important;
    position: relative !important;
}

.pdf-upload-container:hover {
    border-color: #1976d2 !important;
    background: rgba(25, 118, 210, 0.1) !important;
}

.pdf-upload-info {
    margin-top: 15px !important;
}

.pdf-upload-info i {
    font-size: 3rem !important;
    color: #1976d2 !important;
    margin-bottom: 15px !important;
}

.upload-text {
    font-size: 1.1rem !important;
    font-weight: 600 !important;
    color: #333 !important;
    margin-bottom: 15px !important;
}

.upload-requirements {
    text-align: left !important;
    background: rgba(255, 255, 255, 0.8) !important;
    padding: 15px !important;
    border-radius: 8px !important;
    margin: 15px 0 !important;
    font-size: 0.9rem !important;
    line-height: 1.6 !important;
}

.upload-note {
    font-size: 0.85rem !important;
    color: #666 !important;
    font-style: italic !important;
    margin-top: 10px !important;
}

.form-control-file {
    border: none !important;
    padding: 0 !important;
    background: transparent !important;
}

.form-control-file:focus {
    box-shadow: none !important;
}
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const pdfFileInput = document.getElementById('pdf_file');
        const form = document.querySelector('form');
        
        // Client-side PDF validation
        pdfFileInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            const maxSize = 10 * 1024 * 1024; // 10MB in bytes
            
            if (file) {
                // Check file type
                if (file.type !== 'application/pdf') {
                    alert('Please select a PDF file only.');
                    this.value = '';
                    return;
                }
                
                // Check file size
                if (file.size > maxSize) {
                    alert('File size must be less than 10MB.');
                    this.value = '';
                    return;
                }
                
                // Check PDF header
                const reader = new FileReader();
                reader.onload = function(e) {
                    const arr = new Uint8Array(e.target.result);
                    const header = String.fromCharCode.apply(null, arr.subarray(0, 4));
                    
                    if (header !== '%PDF') {
                        alert('The selected file does not appear to be a valid PDF document.');
                        pdfFileInput.value = '';
                        return;
                    }
                    
                    // Show success message
                    showFileValidationMessage('PDF file selected successfully!', 'success');
                };
                reader.readAsArrayBuffer(file);
            }
        });
        
        // Form submission validation
        form.addEventListener('submit', function(e) {
            const pdfFile = pdfFileInput.files[0];
            
            if (!pdfFile) {
                e.preventDefault();
                alert('Please select a PDF file before submitting.');
                return;
            }
            
            // Show loading message
            const submitBtn = form.querySelector('button[type="submit"]');
            submitBtn.innerHTML = '<i class="nc-icon nc-refresh-69"></i> Processing...';
            submitBtn.disabled = true;
        });
        
        function showFileValidationMessage(message, type) {
            // Remove existing messages
            const existingMsg = document.querySelector('.file-validation-message');
            if (existingMsg) {
                existingMsg.remove();
            }
            
            // Create new message
            const msgDiv = document.createElement('div');
            msgDiv.className = `file-validation-message alert alert-${type === 'success' ? 'success' : 'danger'}`;
            msgDiv.innerHTML = message;
            
            // Insert after file input
            pdfFileInput.parentNode.insertBefore(msgDiv, pdfFileInput.nextSibling);
            
            // Auto-remove after 3 seconds
            setTimeout(() => {
                if (msgDiv.parentNode) {
                    msgDiv.remove();
                }
            }, 3000);
        }
    });
</script>
@endsection 