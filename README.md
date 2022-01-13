# Very short description of the package

[![Latest Version on Packagist](https://img.shields.io/packagist/v/uocnv/momo-payment.svg?style=flat-square)](https://packagist.org/packages/uocnv/momo-payment)
[![Total Downloads](https://img.shields.io/packagist/dt/uocnv/momo-payment.svg?style=flat-square)](https://packagist.org/packages/uocnv/momo-payment)

This is a package that helps connect to Momo service with All in one payment method.

## Installation

You can install the package via composer:

```bash
composer require uocnv/momo-payment
```

## Usage

- Publish config:

    ```php
    php artisan vendor:publish --provider="Uocnv\MomoPayment\MomoPaymentServiceProvider" --tag="config"
    ```

- You can start with:

    ```php
    $momoPayment = new MomoPayment(config('momo-payment.environment'));
    ```

- Create a Capture request and receive response with redirect payment url:

    ```php
    $response = $momoPayment->createRequest(array $data);
    $paymentUrl = $response->getPayUrl();
    ```

    *More information in: [Config Api](https://developers.momo.vn/v2/#/docs/aiov2/?id=l%e1%ba%a5y-ph%c6%b0%c6%a1ng-th%e1%bb%a9c-thanh-to%c3%a1n)*

- Processing payment results:

    You can check signature from response

    ```php
    $response     = $momoPayment->checkResult($request->all());
    $errorCode    = $response->getErrorCode();
    $localMessage = $response->getLocalMessage();
    $transId      = $response->getTransId();
    $responseTime = $response->getResponseTime();
    $orderId      = $response->getOrderId();
    $orderInfo    = $response->getOrderInfo();
    $amount       = $response->getAmount();
    ```

    *More information in: [Processing payment results](https://developers.momo.vn/v2/#/docs/aiov2/?id=x%e1%bb%ad-l%c3%bd-k%e1%ba%bft-qu%e1%ba%a3-thanh-to%c3%a1n)*

- Check transaction status:

    ```php
    $response = $momoPayment->checkStatus($orderId, $requestId);
    $errorCode    = $response->getErrorCode();
    $localMessage = $response->getLocalMessage();
    $transId      = $response->getTransId();
    $orderId      = $response->getOrderId();
    $amount       = $response->getAmount();
    ```
  *More information in: [Check transaction status](https://developers.momo.vn/v2/#/docs/aiov2/?id=ki%e1%bb%83m-tra-tr%e1%ba%a1ng-th%c3%a1i-giao-d%e1%bb%8bch)*

### Security

If you discover any security related issues, please email uocnv.soict.hust@gmail.com instead of using the issue tracker.

## Credits

- [Nguyen Van Uoc](https://github.com/uocnv)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

## Laravel Package Boilerplate

This package was generated using the [Laravel Package Boilerplate](https://laravelpackageboilerplate.com).
