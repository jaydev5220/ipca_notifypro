<style>
    input[type=text] {
        outline: none;
    }
</style>
<div class="container py-3">
    <div class="custom-center custom-container">
        <h4 class="ml-0"><i class="fas fa-comments text-success"></i>&nbsp;&nbsp;<u>Notification Template</u></h4>

        <div class="border border-dark pt-4 mt-4 v100">
            <div>
                <p class="ml-1 mb-0"><i class="far fa-envelope text-primary " style="font-size: 24px;"></i></p>
                <div class="pl-3 text-center" style="font-size: 20px;">
                    Dear <?php echo $contact_name ?? '' ?> from <?php echo $company_name ?? '' ?> Company <br>
                    Needs You to Submit <br>
                    following documents <br>
                    Pl click on the below link <br>
                    <a href="<?php echo $bitly_url ?? '#' ?>" class="text-info">bitly.com</a>
                </div>

            </div>
            <div class="m-2">
                <input type="text" class="mb-1" style="width: 80%;border: 2px solid;">&nbsp;
                <i class="far fa-envelope text-primary" style="font-size: 24px;"></i>
            </div>
        </div>
    </div>
</div>