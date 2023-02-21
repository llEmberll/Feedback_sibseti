<?php
require_once "notify.php";


class NotifyError extends Notify {


    public function __construct(string $text) {
        $this->text = $text;
        $this->imageSrc = BASE_URL . '/images/notify/error.png';
    }


    public function create()
    {
        ?>
        <html lang="en">

        <div class="notify error">

            <div class="image-field image-field-error">

                <img class="notify-img error-img" src="<?php echo $this->imageSrc?>" alt="">

            </div>

            <div class="text-field error-text-field">

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
