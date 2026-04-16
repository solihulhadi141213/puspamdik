$('#ProsesSettingGeneral').on('submit', function(e){
    e.preventDefault();

    let form = this;
    let data = new FormData(form);

    let button = $('#ButtonSettingGeneral');
    let notif = $('#NotifikasiSimpanSettingGeneral');

    let originalButton = button.html();

    notif.html('');

    button.prop('disabled', true).html(`
        <span class="spinner-border spinner-border-sm me-2"></span>
        Menyimpan...
    `);

    $.ajax({
        url: '_Page/SettingGeneral/ProsesSettingGeneral.php',
        type: 'POST',
        data: data,
        processData: false,
        contentType: false,
        dataType: 'json',

        success: function(response){
            button.prop('disabled', false).html(originalButton);

            if(response.status){
                notif.html('');

                Swal.fire({
                    toast: true,
                    position: 'top-end',
                    icon: 'success',
                    title: response.message,
                    showConfirmButton: false,
                    timer: 2000
                });

            }else{
                notif.html(`
                    <div class="alert alert-danger rounded-3">
                        ${response.message}
                    </div>
                `);
            }
        },

        error: function(){
            button.prop('disabled', false).html(originalButton);

            notif.html(`
                <div class="alert alert-danger rounded-3">
                    Terjadi kesalahan server
                </div>
            `);
        }
    });
});