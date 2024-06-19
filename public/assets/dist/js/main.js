
$(document).ready(function() {
	
	// --------------- APPLICATION BASE URL ------------ //
	var baseUrl = $('#base-url').val();

	// --------------- ON CHANGE TEXT ----------------- //
	$(document).on('keyup', '#text', function(e) {
		e.preventDefault();
		
		var val = $(this).val();

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
		$('#btn-save-text').attr('disabled', '');
	});

	// --------------- ON CLICK BTN SAVE TEXT --------------- //
	$(document).on('click', '#btn-save-text', function(e) {
		e.preventDefault();
		
		var self = $(this);
			self_html = self.html();

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
    $('.drag-drop-wrap').on('dragover', function(e) {
        e.preventDefault();
        e.stopPropagation();
        if (!$('.file').length) {
            $(this).addClass('drag-over');
        }
    });

    // -------------- ON DRAG LEAVE ------------- //
    $('.drag-drop-wrap').on('dragleave', function(e) {
        e.preventDefault();
        e.stopPropagation();
        $(this).removeClass('drag-over');
    });

    // -------------- ON DROP ------------- //
    $('.drag-drop-wrap').on('drop', function(e) {
        e.preventDefault();
        e.stopPropagation();
        $(this).removeClass('drag-over');
        var files = e.originalEvent.dataTransfer.files;
        handleFiles(files);
    });

    // -------------- HANDLE FILES FUNCTION ------------- //
    function handleFiles(files) {
        if (files.length > 0) {
            $('.files-wrap').removeClass('d-none');
            $('.drag-drop-wrap').removeClass('no-file');
            $('.no-file-upload-wrap').addClass('d-none');

            var fileDetails = ``;
            var readers = []; // To keep track of all FileReader instances

            for (var i = 0; i < files.length; i++) {
                var file = files[i];
                if (file.type.startsWith('image/')) {
                    // For image files, create a URL and display the image
                    var reader = new FileReader();
                    readers.push(reader); // Keep track of this reader

                    reader.onload = (function(file) {
                        return function(e) {
                            fileDetails += `<div class="file">
                                <div class="preview">
                                    <img src="${e.target.result}" alt="${file.name}" class="img-preview">
                                </div>
                            </div>`;
                            // Check if all readers are done before updating the DOM
                            checkAllReadersDone();
                        };
                    })(file);
                    reader.readAsDataURL(file);
                } else {
                    // For non-image files, display the file name
                    fileDetails += `<div class="file">
                        <div class="preview">
                            <i class="fas fa-file"></i>
                            <p>${file.name}</p>
                        </div>
                    </div>`;
                }
            }

            // If there are no image files, directly update the DOM
            if (readers.length === 0) {
                $('.add-new-file').before(fileDetails);
            }

            function checkAllReadersDone() {
                if (readers.every(function(reader) { return reader.readyState === 2; })) {
                    $('.add-new-file').before(fileDetails);
                }
            }
        }
    }
});