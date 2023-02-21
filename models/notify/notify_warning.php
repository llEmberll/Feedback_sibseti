<?php
require_once "notify.php";


class NotifyWarning extends Notify {


    public function __construct(string $text) {
        $this->text = $text;
        $this->imageSrc = BASE_URL . '/images/notify/warning.png';
    }


    public function create()
    {
        ?>
        <html lang="en">

        <div class="notify warning">

            <div class="image-field image-field-warning">

                    <img class="notify-img warning-img" src="<?php echo $this->imageSrc?>" alt="">

            </div>

            <div class="text-field warning-text-field">

                <p>

                    <?php echo $this->text?>

                </p>

            </div>

        </div>

        </html>

        <?php
    }


    public function delete()
    {

    }
}