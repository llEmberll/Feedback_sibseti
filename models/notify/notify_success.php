<?php
require_once "notify.php";


class NotifySuccess extends Notify {


    public function __construct(string $text) {
        $this->text = $text;
        $this->imageSrc = BASE_URL . '/images/notify/success.png';
    }


    public function create()
    {
        ?>
        <html lang="en">

        <div class="notify success">

            <div class="image-field image-field-success">

                <img class="notify-img success-img" src="<?php echo $this->imageSrc?>" alt="">

            </div>

            <div class="text-field success-text-field">

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
