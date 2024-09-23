<script type="text/javascript">
    $(document).ready(function() {
        $('body').on("click", "#form_kecamatan", function() {
            var id = $('#form_kecamatan').val(); 
            var data = "id=" + id + "&data=kelurahan";

            $.ajax({
                type: 'POST',
                url: "<?= base_url('kelurahan/getKelurahanFile'); ?>",
                data: data,
                success: function(hasil) {
                    $("#form_kelurahan").html(hasil);
                    $("#form_kelurahan").show();
                }
            });
        });
    });
</script>
