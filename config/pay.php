<?php

declare(strict_types=1);

use Yansongda\Pay\Pay;

return [
    'alipay' => [
        'default' => [
            // 支付宝分配的 app_id
            'app_id' => '2021000118659304',
            // 应用私钥
            'app_secret_cert' => 'MIIEowIBAAKCAQEAwPpO7J7BR0ewd22ptDEeM+s/gFQPAAm9yA67ZHf09cBmfwZ9gmnR9d/SVW8zhnIRie2VdkZagvrWQc2N3wzN636dEREc8NN1mgpQyVsR60u43fjw0zKgVGCabAlwnqE/3TPLGsBiD/nFYnVXwZQu0LLhwrgB3ewgrNH3Uk50fFLwm6R+YBRn09VxeuaY5C63X/yNw3SpF+KLl5GJEd2AtHkMGfRs6dusMMTAqRLHsnM6je7na7WzDb60Whw7oySRZ5KON9F53o1D+GFwWj42g1P6dcK6WvF7E06pmJnZwOL+rPksK7dis+JqoH7KWwFY9aGTXg2NfFZLvxqbC7bigQIDAQABAoIBAQCcrJxXT6zsCjAjRk15lkdHL7+mmJh1F3OVcSCDOUEQJN0SVFqh/vgP/1/tLRNQHFxQ9ytZk1T48l3xnsmIRgUJJQqwSIyOmZ/pKGbek6nAtwGodexQC9JPrv6wqBlfMNuA5AQJ/BehkM/IWCyfZYd8uT7BsFMTshn1NaLul/PK2sJBe4Xq5Ny57FPc2QrbPg6PngyefuzU4UHpFtDp34lD0SEg6/NUd90A2SURXEb+9a/FwTtL4ZGP9hN4D5RhZ47fvuqq4eUz9UHF2ZZkuOK8HcHNhxTFUNrQ08fNJJHOsmD9E3FtQyHBguOyR8yevWImtpNXcC2M3hEfjbpOQ1oBAoGBAOpvmAt4WeGhw7T+RjdAmQinuELseviIdo+YKBkoIdRvFm/pyMGiXLc1kh+JRkg/3jh5gGL2ZstlsyQul9txwcFgm3evj1wBVOYsYpdE/qw7HigNNlt3Zy2AMS+QzXSIlHI2XxvZMMOq0pT9jXgbapJqD8fSIp9+O57petPgjbSJAoGBANK6eVdaiEHrW3TGARIittpDgMdpVmWtkaweZKea+r5iR652FVL67E0e9t0eaBzvWHf/fPI/NKquIN7QoGAcd3sLK9jI8FLz6u88waCz3u6Gj/n/z8GiWU3WBK+Q9RW4sNrVHPBBpSYdUu/S2LFTq90yRKZ9Y83eBjU3tA2z0DA5AoGAPIsXTBcHt1KMdUiZn5lKLEcMOhRSaa7sV4cnC+AmZHNP6xUIKKGiqhnmo8hS40PDQvh15JjX0T1xdy2lQCHvtN4bKFypfExHva3GxGQoFRirYBKRcCu09LY/fZY6yRagp6JNC6cahd2uxpV4nIUQD8HeU298S45RHWgUtXUvg2kCgYA3gfUahHdl3cgeb1Wy4EAIKEXQwTeH2vuHOg5Lc/Bem+bD1sjxLbV27xQZ1LuZ+5XzLfJMoUePOgTgjFXiWz1BxQSMuwlK4INe90MNwLOVYw6jzLV+DPS3Iwvi7y0PxrGXQxG3W6NT8d952rFHrIGV53rb3CWhAb3i4MRl45qQSQKBgCKPG3Cu0IhkdlKiv/m9M2fBet6IuOVd2EtO79faScTASdfPKqKTIp1Xi58vpzTafcxbKbqMiC74VlVFCOEb14mRgCR2tTpqTC/lmOQ0MuJc+RwbjzX7XFyRFnE2oQtFEUP0MsrNS+hN7oeCfZDBQxWuk64Jwyzpc9uAXBYkLXBw',
            // 应用公钥证书 路径
            'app_public_cert_path' => './cert/appCertPublicKey_2021000118659304.crt',
            // 支付宝公钥证书 路径
            'alipay_public_cert_path' => './cert/alipayCertPublicKey_RSA2.crt',
            // 支付宝根证书 路径
            'alipay_root_cert_path' => './cert/alipayRootCert.crt',
            'return_url' => '',
            'notify_url' => '',
            'mode' => Pay::MODE_NORMAL,
        ],
    ],
    'wechat' => [
        'default' => [
            // 公众号 的 app_id
            'mp_app_id' => '',
            // 小程序 的 app_id
            'mini_app_id' => '',
            // app 的 app_id
            'app_id' => '',
            // 商户号
            'mch_id' => '',
            // 合单 app_id
            'combine_app_id' => '',
            // 合单商户号
            'combine_mch_id' => '',
            // 商户秘钥
            'mch_secret_key' => '',
            // 商户私钥
            'mch_secret_cert' => '',
            // 商户公钥证书路径
            'mch_public_cert_path' => '',
            // 微信公钥证书路径
            'wechat_public_cert_path' => [
                '' => '',
            ],
            'notify_url' => '',
            'mode' => Pay::MODE_NORMAL,
        ],
    ],
    'http' => [ // optional
        'timeout' => 5.0,
        'connect_timeout' => 5.0,
        // 更多配置项请参考 [Guzzle](https://guzzle-cn.readthedocs.io/zh_CN/latest/request-options.html)
    ],
    // optional，默认 warning；日志路径为：sys_get_temp_dir().'/logs/yansongda.pay.log'
    'logger' => [
        'enable' => false,
        'file' => null,
        'level' => 'debug',
        'type' => 'single', // optional, 可选 daily.
        'max_file' => 30,
        //'mode'=>'dev',
    ],
];
