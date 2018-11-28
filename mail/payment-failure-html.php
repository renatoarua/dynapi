<?php
use yii\helpers\Html;
use yii\helpers\Url;
/* @var $this \yii\web\View view component instance */
/* @var $message \yii\mail\BaseMessage instance of newly created mail message */
?>
<?php $this->beginPage() ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>DynTechnologies</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<link href="https://fonts.googleapis.com/css?family=Roboto+Mono:400,900" rel="stylesheet" type='text/css'>
<style type="text/css">body{color: #3fbbb0;}.social{display: table;margin: 0 auto;}.social ul{padding: 0px;margin: 16px 0 0 0;text-align:center;}.social ul li{display: inline;}.social ul li a{display: inline-block;margin: 5px;text-align: center;}.social img{width: 35px;}.newsletter{background-color: rgba(0, 0, 0, 0.8);padding: 25px 0;max-width: 800px;margin: 0 auto;border-radius: 20px 20px;text-align: center;box-shadow: 0 2px 5px 0 rgba(0,0,0,0.16),0 2px 10px 0 rgba(0,0,0,0.12);}h1 {font-size: 38px;line-height: 52px;font-style: normal;font-weight: 900;font-family: "Roboto Mono";letter-spacing: 2.5px;margin: 0 auto;position: relative;text-align: center;}h2{font-size: 30px;line-height: 36px;font-weight: 400;font-style: normal;font-family: "monospace", cursive;margin: 0 auto;position: relative;text-align: center;}.banner{margin-top: 20px;/*background-image: url("http://dyntechnologies.com.br/mail/polygon-back.png");*/padding: 40px 0;background-size: cover;}.banner h1{color: #e3f7d2;text-transform: none;}.content{padding: 40px 0;max-width: 80%;margin: 0 auto;text-align: center;font-weight: 400;font-size: 24px;font-family: "Roboto Mono"}.disclaimer{font-weight: 400;font-size: 16px;color: #e3f7d2;font-family: "monospace"}.copyright{font-weight: 600;font-size: 18px;font-family: "monospace"}.logo svg {height: 175px; fill: #3fbbb0;}h1.logo{overflow: hidden;text-align: center;}h1.logo:before,h1.logo:after {background-color: #3fbbb0;content: "";display: inline-block;height: 5px;position: relative;vertical-align: middle;width: 50%;}h1.logo:before {right: 0.5em;margin-left: -50%;}h1.logo:after {left: 0.5em;margin-right: -50%;}</style>
</head>
<body>
    <?php $this->beginBody() ?>
    <section class="newsletter">
        <div class="container">
            <div class="row">
                <div class="col s12 logo">
                    <svg version="1.1" id="logo" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                     viewBox="0 0 92.83 70.7" style="enable-background:new 0 0 92.83 70.7;" xml:space="preserve">
                        <g>
                            <path d="M92.16,17.38q-4-3.15-11.62-3.15H60.06V1.63H39.45v12.6H19q-7.6,0-11.62,3.15T3.33,27V59.52c0,4.28,1.34,7.48,4,9.58S13.89,72.26,19,72.26L50,72.33l30.51-.07q7.6,0,11.62-3.15c2.67-2.1,4-5.3,4-9.58V27Q96.17,20.53,92.16,17.38Zm-16.61,42H23.95V27.23H39.45V53H60.06V27.23H75.55Z" transform="translate(-3.33 -1.63)"/>
                        </g>
                    </svg>
                </div>
                <div class="col s12">
                    <h1 class="logo">DYN Techonologies</h1>
                </div>
                <div class="col s12">
                    <h2>Innovating computer engineering</h2>
                </div>
            </div>
            <div class="row banner">
                <div class="col s12">
                    <h1 class="title">Hello, <?= Html::encode($data['username']) ?></h1>
                </div>
            </div>
            <div class="row content">
                <div class="col s12">
                    <div class="col s6">
                        You have ordered calculations in one project.
                        <br />
                        <br />Please click this link:
                        <br /><br />
                        <a href="<?=Html::encode($data['loginURL']);?>"><?=$data["loginURL"];?></a>
                        <br />
                        <br />Thank you for using <?=$data['appName'];?>!
                        <br />The Team
                    </div>
                </div>
            </div>
            <div class="contact">
                <div class="row">
                    <div class="col s12 disclaimer">
                        <p><?= $data['disclaimer'] ?></p>
                    </div>
                </div>
                <div class="row">
                    <div class="col s12">
                        <div class="col s12 social">
                            <ul>
                              <li><a href="https://www.facebook.com/dyntech/" class="btn-luxore btn-large" target="_blank"><img src="http://dyntechnologies.com.br/mail/facebook.png"></i></a></li>
                              <li><a href="https://twitter.com/dyntech" class="btn-luxore btn-large" target="_blank"><img src="http://dyntechnologies.com.br/mail/twitter.png"></i></a></li>
                              <li><a href="https://www.instagram.com/dyntech/" class="btn-luxore btn-large" target="_blank"><img src="http://dyntechnologies.com.br/mail/instagram.png"></i></a></li>
                            </ul>
                          </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col s12 copyright">
                        © <?php echo date('Y'); ?> DYN Technologies
                    </div>
                </div>
            </div>
        </div>  
    </section>
    <?php $this->endBody() ?>
</body></html>
<?php $this->endPage() ?>

