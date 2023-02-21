<?php
require_once "notify.php";


class NotifyInfo extends Notify {


    public function __construct(string $text) {
        $this->text = $text;
        $this->imageSrc = BASE_URL . '/images/notify/info.png';
    }


    public function create()
    {
        ?>
        <html lang="en">

        <div class="notify info">

            <div class="image-field image-field-info">

                <img class="notify-img info-img" src="<?php echo $this->imageSrc?>" alt="">

            </div>

            <div class="text-field info-text-field">

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