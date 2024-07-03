
$(document).ready(function() {
	
	// --------------- APPLICATION BASE URL ------------ //
	var baseUrl = $('#base-url').val();

    // --------------- AJAX CSRF META ------------ //
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

	// --------------- ON CHANGE TEXT ----------------- //
	$(document).on('keyup', '#text', function(e) {
		e.preventDefault();
		
		var val = $(this).val();

        $('#btn-save-text').text('Save').attr('action', 'save');

		if (val != '') {
			$('#btn-save-text').removeAttr('disabled');
			$('#btn-clear').removeClass('d-none');
		} else {
			$('#btn-save-text').attr('disabled', '');
			$('#btn-clear').addClass('d-none');
		}
	});

	// --------------- ON CLICK BTN CLEAR -----------------//
	$(document).on('click', '#btn-clear', function(e) {
		e.preventDefault();
		$('#text').val('');
		$(this).addClass('d-none');
		$('#btn-save-text').attr('action', 'save').trigger('click');
	});

	// --------------- ON CLICK BTN SAVE TEXT --------------- //
	$(document).on('click', '#btn-save-text', function(e) {
		e.preventDefault();
		
		var self = $(this);
            url = self.data('url');
			action = self.attr('action');
            text = $('#text').val();

        if (action == 'copy') {
            $('#text').select();
            document.execCommand('copy');
            return;
        }

        // Button Loading
        self.attr('disabled', '').html('Saving...');

        $.ajax({
            url: url,
            type: 'POST',
            data: { text: text },
            success: function(response) {
                if (text == '') {
                    self.attr({
                        disabled: '',
                        action: 'save'
                    }).html('Save');
                } else {
                    self.removeAttr('disabled').html('Copy').attr('action', 'copy');
                }
            },
            error: function() {
                alert('Something went wrong !');
            }
        });
	});

	// -------------- ON CLICK BROWSE FILE LINK ------------- //
	$(document).on('click', '#browse, .add-new-file', function(e) {
        e.preventDefault();
        $('#file-input').click();
    });

	// -------------- ON CHANGE FILE INPUT ------------- //
    $(document).on('change', '#file-input', function() {
        handleFiles(this.files);
    });

    // -------------- ON DRAG OVER ------------- //
    $(document).on('dragover', '.drag-drop-wrap', function(e) {
        e.preventDefault();
        e.stopPropagation();
        if (!$('.file').length) {
            $(this).addClass('drag-over');
        }
    });

    // -------------- ON DRAG LEAVE ------------- //
    $(document).on('dragleave', '.drag-drop-wrap', function(e) {
        e.preventDefault();
        e.stopPropagation();
        $(this).removeClass('drag-over');
    });

    // -------------- ON DROP ------------- //
    $(document).on('drop', '.drag-drop-wrap', function(e) {
        e.preventDefault();
        e.stopPropagation();
        $(this).removeClass('drag-over');
        var files = e.originalEvent.dataTransfer.files;
        handleFiles(files);
    });

    // -------------- ON CLICK ON FILE ------------- //
    $(document).on('click', '.file', function(e){
        e.preventDefault();

        var source = $(this).attr('data-src');

        if (source) {
            const url = baseUrl + '/uploads/' + source;
            const link = document.createElement('a');
            link.href = url;
            link.download = url.split('/').pop(); // This sets the file name
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
        }
    });

    // -------------- ON SUBMIT FORM FILE UPLOAD ------------- //
    $(document).on('submit', '.upload-file-form', function(e){
        e.preventDefault();
        
        var form = $(this);
            formData = new FormData(form[0]);
            url = baseUrl + '/upload';

        $.ajax({
            url: url,
            type: 'POST',
            data: formData,
            enctype: 'multipart/form-data',
            processData: false,
            contentType: false,
            cache: false,
            xhr: function() {
                var xhr = new window.XMLHttpRequest();
                
                // Upload progress
                xhr.upload.addEventListener('progress', function(event) {
                    if (event.lengthComputable) {
                        var percentage = (event.loaded / event.total) * 100;
                        updateProgress(percentage, form);
                    }
                }, false);
                
                return xhr;
            },
            success: function(response) {
                if (response.status == true) {
                    form.parent('.file').addClass('complete');
                    form.parent('.file').attr('data-src', response.file.source);
                    form.find('.file-loading').remove();
                } else {
                    form.find('.file-loading').html(`
                        <div class="file-error">
                            <i class="fas fa-warning"></i>
                            <p>Uploading Failed</p>
                        </div>
                    `);
                }
            },
            error: function() {
                form.find('.file-loading').html(`
                    <div class="file-error">
                        <i class="fas fa-warning"></i>
                        <p>Uploading Failed</p>
                    </div>
                `);
            },
            complete: function() {
                //
            }
        });
    });

    // -------------- ON CLICK SELECT FILES ------------ //
    $(document).on('click', '#btn-select-files', function(e) {
        e.preventDefault();
        
        var self = $(this);
            selfHtml = self.html();
            action = self.data('action');

        if (action == 'select') {
            
        }

        if (action == 'cancel') {
            //
        }
    });

    // -------------- HANDLE FILES FUNCTION ------------- //
    function handleFiles(files) {
        if (files.length > 0) {
            $('.files-wrap').removeClass('d-none');
            $('.drag-drop-wrap').removeClass('no-file');
            $('.no-file-upload-wrap').addClass('d-none');

            var fileDetails = ``;
            var readers = []; // To keep track of all FileReader instances
            var uploadedFilesLength = $('.files-wrap .file').length;

            for (var i = 0; i < files.length; i++) {

                var file = files[i];
                    formDataId = (i + 1) + uploadedFilesLength;

                if (file.type.startsWith('image/')) {
                    // For image files, create a URL and display the image
                    var reader = new FileReader();
                    readers.push(reader); // Keep track of this reader

                    reader.onload = (function(file) {
                        return function(e) {
                            $('.add-new-file').before(`
                                <div class="file">
                                    <form data-id="${formDataId}" class="upload-file-form">
                                        <input type="file" name="file" class="d-none">
                                        <div class="preview">
                                            <img src="${e.target.result}" alt="${file.name}" class="img-preview">
                                        </div>
                                        <div class="file-loading">
                                            <div class="file-progress-bar">
                                                <svg viewBox="0 0 100 100" class="progress-container">
                                                    <circle cx="50" cy="50" r="40" class="progress-background"/>
                                                    <circle cx="50" cy="50" r="40" class="progress-bar"/>
                                                    <text x="50" y="50" class="progress-text">0%</text>
                                                </svg>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            `);

                            var form = $('.upload-file-form[data-id="'+formDataId+'"]');
                            var dataTransfer = new DataTransfer();
                            dataTransfer.items.add(file);
                            form.find('input[type="file"]')[0].files = dataTransfer.files;
                            form.submit();
                        };
                    })(file);
                    reader.readAsDataURL(file);
                } else {
                    $('.add-new-file').before(`
                        <div class="file no-image">
                            <form data-id="${formDataId}" class="upload-file-form">
                                <input type="file" name="file" class="d-none">
                                <div class="preview">
                                    <i class="fas fa-file"></i>
                                    <p>${file.name}</p>
                                </div>
                                <div class="file-loading">
                                    <div class="file-progress-bar">
                                        <svg viewBox="0 0 100 100" class="progress-container">
                                            <circle cx="50" cy="50" r="40" class="progress-background"/>
                                            <circle cx="50" cy="50" r="40" class="progress-bar"/>
                                            <text x="50" y="50" class="progress-text">0%</text>
                                        </svg>
                                    </div>
                                </div>
                            </form>
                        </div>
                    `);

                    var form = $('.upload-file-form[data-id="'+formDataId+'"]');
                    var dataTransfer = new DataTransfer();
                    dataTransfer.items.add(file);
                    form.find('input[type="file"]')[0].files = dataTransfer.files;
                    form.submit();
                }
            }
        }
    }

    function updateProgress(percent, form) {
        const progressBar = form.find('.progress-bar'); // Select the jQuery object directly
        const circumference = 2 * Math.PI * parseFloat(progressBar.attr('r'));
        const offset = circumference * (1 - percent / 100); // Calculate offset from top center
        
        progressBar.css('strokeDasharray', `${circumference} ${circumference}`);
        progressBar.css('strokeDashoffset', offset);
        
        form.find('.progress-text').text(`${percent.toFixed(0)}%`);
    }
});