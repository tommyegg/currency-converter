# 環境建置
安裝composer套件
```shell
composer install
```

測試環境啟動
```shell
./vendor/bin/sail up -d
```

測試API
```shell
curl --request GET 'http://127.0.0.1/api/convert?amount=$100&source=TWD&target=JPY'
```

單元測試
```shell
./vendor/bin/sail test
```

# API 說明文件

## 轉換 API

這個 API 允許你將一個金額從一種貨幣轉換成另一種貨幣。

### 請求

- 路徑：`/api/convert`
- 方法：GET

#### 參數

| 參數名稱 | 類型   | 必填 | 說明                       |
| -------- | ------ | ---- | -------------------------- |
| amount   | 字串   | 是   | 要轉換的金額               |
| source   | 字串  | 是   | 原始貨幣代碼，例如：TWD     |
| target   | 字串  | 是   | 目標貨幣代碼，例如：JPY     |

### 回應

成功回應將返回一個包含轉換後金額的 JSON 物件。

```json
{
    "msg": "success",
    "amount": "$366.90"
}
```


