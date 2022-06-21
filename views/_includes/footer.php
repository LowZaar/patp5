</div>

    </div>
    <!-- Bootstrap JS-->
    <!-- <script src="<?= HOME_URI ?>/node_modules/bootstrap-4.1/popper.min.js"></script> -->
    <script src="<?= HOME_URI ?>/node_modules/bootstrap/dist/js/bootstrap.min.js"></script>
    <!-- Vendor JS -->
    <!-- <script src="<?= HOME_URI ?>/node_modules/slick/slick.min.js"></script> -->
    <!-- <script src="<?= HOME_URI ?>/node_modules/wow/wow.min.js"></script> -->
    <script src="<?= HOME_URI ?>/node_modules/animsition/dist/js/animsition.min.js"></script>
    <script src="<?= HOME_URI ?>/node_modules/bootstrap-progressbar/bootstrap-progressbar.min.js">
    </script>
<!--    <script src="'--><?//=HOME_URI?><!--/node_modules/jquery-mask-plugin/src/jquery.mask.js"></script>-->
    <!-- <script src="<?= HOME_URI ?>/node_modules/counterup/jquery.waypoints.min.js"></script> -->
    <script src="<?= HOME_URI ?>/node_modules/counterup/jquery.counterup.min.js">
    </script>
    <!-- <script src="<?= HOME_URI ?>/node_modules/circle-progress/dist/components/circle-progress.js"></script> -->
    <!-- <script src="<?= HOME_URI ?>/node_modules/perfect-scrollbar/perfect-scrollbar.js"></script> -->
    <script src="<?= HOME_URI ?>/node_modules/chartjs/chart.js"></script>
    <script src="<?= HOME_URI ?>/node_modules/select2/dist/js/select2.min.js"></script>
    <script src="<?= HOME_URI ?>/node_modules/ckeditor/ckeditor.js"></script>

    <!-- Jquery Mask -->
    <script src="<?= HOME_URI ?>/node_modules/jquery-mask-plugin/dist/jquery.mask.min.js"></script>

    <!-- Main JS-->
    <script src="<?= HOME_URI ?>/views/_js/main.js"></script>
    <script src="<?= HOME_URI ?>/views/_js/scripts.js"></script>

    <script>
        function showNotificatonModal(title, msg, type){
            switch (type) {
                case 'success':
                    classe = 'success';
                    break;
                case 'error':
                    classe = 'danger';
                    break;
                case 'warning':
                    classe = 'warning';
                    break;
                default:
                    classe = 'primary';
                    break;
            }

            let i = Math.floor(Math.random()*1000);

            $('#notification-panel').append(`
                <div class="sufee-alert alert with-close alert-${classe} alert-dismissible fade notification" id="${i}">
					<span class="badge badge-pill badge-${classe}">${title}</span>
						${msg}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
				</div>
            `);

            setTimeout(() => {
                $('#'+i).addClass('show').trigger('classChange');
            }, 500);

            $('#'+i).on('classChange', () => {
                console.log('caiu')
                setTimeout(() => {
                    $('#'+i).removeClass('show');
                    setTimeout(() => {
                        $('#'+i).remove()
                    }, 500);
                }, 5000);
            })
        }
    </script>

    <?php if (isset($_SESSION['notification'])) { ?>
        <script>
             switch ('<?=$_SESSION['notification']['type']?>') {
                case 'success':
                    classe = 'success';
                    break;
                case 'error':
                    classe = 'danger';
                    break;
                case 'warning':
                    classe = 'warning';
                    break;
                default:
                    classe = 'primary';
                    break;
            }

            let i = Math.floor(Math.random()*1000);

            $('#notification-panel').append(`
                <div class="sufee-alert alert with-close alert-${classe} alert-dismissible fade notification" id="${i}">
					<span class="badge badge-pill badge-${classe}"><?=$_SESSION['notification']['title']?></span>
                        <?=$_SESSION['notification']['msg']?>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
				</div>
            `);

            setTimeout(() => {
                $('#'+i).addClass('show').trigger('classChange');
            }, 500);

            $('#'+i).on('classChange', () => {
                console.log('caiu')
                setTimeout(() => {
                    $('#'+i).removeClass('show');
                    setTimeout(() => {
                        $('#'+i).remove()
                    }, 500);
                }, 5000);
            })
        </script>
    <?php unset($_SESSION['notification']);
        } ?>

</body>

</html>
<!-- end document-->
