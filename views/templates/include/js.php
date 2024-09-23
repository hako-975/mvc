<!-- jQuery -->
<script src="<?= base_url('assets/vendor/jquery/jquery-3.6.0.min.js'); ?>"></script>
<script src="<?= base_url('assets/vendor/jquery-easing/jquery.easing.min.js'); ?>"></script>
<!-- popper -->
<script src="<?= base_url('assets/vendor/popper/popper.min.js'); ?>"></script>
<!-- Bootstrap 4 -->
<script src="<?= base_url('assets/vendor/bootstrap/js/bootstrap.min.js'); ?>"></script>
<!-- overlayScrollbars -->
<script src="<?= base_url('assets/vendor/overlayScrollbars/js/jquery.overlayScrollbars.min.js'); ?>"></script>
<!-- datatables -->
<script src="<?= base_url('assets/vendor/datatables/js/jquery.dataTables.min.js'); ?>"></script>
<script src="<?= base_url('assets/vendor/datatables/js/dataTables.bootstrap4.min.js'); ?>"></script>
<!-- fancybox -->
<script src="<?= base_url('assets/vendor/fancybox/js/jquery.fancybox.min.js'); ?>"></script>
<!-- sweetalert2 -->
<script src="<?= base_url('assets/vendor/sweetalert2/sweetalert2.all.min.js'); ?>"></script>
<!-- AdminLTE App -->
<script src="<?= base_url('assets/vendor/adminlte/js/adminlte.min.js'); ?>"></script>
<!-- Chart JS -->
<script src="<?= base_url('assets/vendor/chart/chart.min.js'); ?>"></script>

<!-- config -->
<script src="<?= base_url('assets/js/jquery-easing-config.js'); ?>"></script>
<script src="<?= base_url('assets/js/datatables-config.js'); ?>"></script>
<script src="<?= base_url('assets/js/fancybox-config.js'); ?>"></script>
<script src="<?= base_url('assets/js/sweetalert2-config.js'); ?>"></script>
<script src="<?= base_url('assets/js/popover-config.js'); ?>"></script>
<script src="<?= base_url('assets/js/toast-config.js'); ?>"></script>

<script>
$(document).on('change', '.file-input-drop', function () {
    var files = this.files;
    var previewDiv = $('#previewDiv');
    var pdfPreview = document.getElementById('pdf-preview');

    // Clear the existing content of pdf-preview container
    pdfPreview.innerHTML = '';

    if (files.length > 0) {
        previewDiv.removeClass('d-none').addClass('d-block');
    } else {
        previewDiv.removeClass('d-block').addClass('d-none');
    }

    var textbox = document.querySelector('.file-message');
    textbox.innerHTML = '';

    for (var i = 0; i < files.length; i++) {
        var file = files[i];
        var fileName = file.name.split('\\').pop();
        var fileType = file.type;

        // Create a new object for each file
        var fileObj = document.createElement('object');
        fileObj.className = 'file-preview';
        fileObj.data = URL.createObjectURL(file); // Set data to a URL representing the file content
        fileObj.style = "width:100%;height:700px";
        
        // Append the file name below the preview
        var fileNameDiv = document.createElement('div');
        fileNameDiv.textContent = 'Nama File: ' + fileName;
        pdfPreview.appendChild(fileNameDiv);

        // Append the file object to the pdf-preview container
        pdfPreview.appendChild(fileObj);
        
        if (fileName == '') {
            textbox.innerHTML += '<div class="file-message">drag and drop files here</div>';
        } else {
            textbox.innerHTML += '<div class="file-message">• ' + fileName + '</div>';
        }
    }
});
</script>


<?php if ($this->session->userdata('id_user')): ?>
    
<script>
    var idleTime = 0;

    // Increment the idle time counter every minute.
    var idleInterval = setInterval(timerIncrement, 60000); // 1 minutes

    // Reset the idle timer on mouse movement or keypress.
    $(document).mousemove(resetTimer);
    $(document).keypress(resetTimer);
    $(document).click(resetTimer); // Detect clicks

    function resetTimer() {
        idleTime = 0;
    }

    function timerIncrement() {
        idleTime++;
        if (idleTime >= 5) { // 5 minutes
            window.location.href = '<?php echo base_url("auth/logout"); ?>';
        }
    }

</script>

<?php endif ?>