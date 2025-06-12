<!DOCTYPE html
    PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <!-- If you delete this meta tag, Half Life 3 will never be released. -->
    <meta name="viewport" content="width=device-width" />
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>Product Notification</title>
    <style>
        a {
            text-decoration: none;
        }

        p {
            margin: 2px 0;
            font-size: 16px;
            color: #454545 !important;
        }

        /* Begin: Layout*/
        body {
            margin: 0;
            padding: 0;
        }

        .body {
            margin: 0;
            padding: 0;
            font-family: arial;
            background-color: #F3F6F9 !important;
            padding-top: 50px;
            padding-bottom: 50px;
            text-align: justify;
            line-height: 1.5em;
        }

        .btn {
            color: #fff !important;
            background-color: #F64E60;
            border: 0;
            display: inline-block;
            padding: 0.65rem 1rem;
            font-size: 18px;
            border-radius: 0.2rem;
        }

        .btn-link {
            text-decoration: underline;
            color: #747474 !important;
        }

        .portlet {
            flex: 0 0 60%;
            max-width: 60%;
            border-radius: 0.2rem;
            background: #fff;
            margin-left: auto;
            margin-right: auto;
            font-size: 16px;
            -webkit-box-shadow: 0px 0px 30px 0px rgba(82, 63, 105, 0.05);
            box-shadow: 0px 0px 30px 0px rgba(82, 63, 105, 0.05);
            border: 0;
        }

        .portlet .portlet-header {
            padding: 1rem 2.25rem;
            border-bottom: 1px solid #ECF0F3;
            /* background-color: #f24545; */
        }

        .portlet .portlet-content {
            padding: 2.25rem;
        }

        .portlet .portlet-footer {
            padding: 2rem 2.25rem;
        }

        .responsive-barcode {
            width: 70%;
            height: 60px;
        }

        .responsive-logo {
            height: auto !important;
            width: 40%;
        }

        .footer {
            padding: 16px;
            background-color: rgba(72, 186, 196, 0.12);
        }

        .footer .footer-title {
            font-size: 16px;
            font-weight: 600;
            padding-bottom: 8px;
        }

        .footer .footer-desc {
            font-size: 14px;
        }

        /* End: Layout */

        /* Begin: Mobile */
        @media only screen and (max-width: 768px) {
            .portlet {
                flex: 0 0 90%;
                max-width: 90%;
            }

            .responsive-barcode {
                width: 100%;
                height: 60px;
            }

            .responsive-logo {
                height: auto !important;
                width: 75%;
            }
        }

        /* End: Mobile */

        .tbl-detail-price {
            width: 95%;
            border: 1px solid black;
        }
    </style>

</head>

<body>

    <!-- BEGIN: Body -->
    <div class="body">

        <div class="portlet">
            <div class="portlet-header primary white-text">
                <center>
                    <a title="RKC-MPD ERIA" href="{{ url('/') }}" target="_blank">
                        <img src="{{ asset('/images/rkcmpd-eria.png') }}" class="responsive-logo">
                    </a>
                </center>
            </div>

            <div class="portlet-content">
                <p style="margin-top: 0; font-size: 18px; padding-bottom: 8px;">Dear
                    {{ $data->product_creator->nama_lengkap }},</p>

                <p style="margin-top: 0; font-size: 15px; padding-bottom: 8px;">
                    Your product has been <b>Updated</b> by an admin. Please check your product information again to continuing the process.
                </p>

                <br>
                <center>
                    <a href="{{ route('user.product.edit', $data->slug) }}" target="_blank"
                        style="padding: 0.65rem 1rem; border-radius:5px; color: #fff; background-color:#334E9E">
                        Check Product
                    </a>
                </center>
                <br>
                <br>
                <br>
                <hr>

                <br>
                <p>Best Regards,</p>
                <p>RKC-MPD ERIA</p>
                <p>Website: <a href="{{ url('/') }}" target="_blank">rkcmpd-eria.com</a></p>
            </div>
        </div>
    </div>
    <!-- END: Body -->

</body>

</html>
