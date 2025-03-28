# Sipariş ve İndirim API Servisi

Bu proje, Laravel kullanılarak geliştirilmiş bir RESTful API servisidir. Servis, siparişlerin eklenmesi, silinmesi ve listelenmesi işlemlerini gerçekleştirir ve belirli kurallara göre indirimleri hesaplar.

## İndirim Kuralları
- **Toplam 1000 TL ve üzeri alışveriş:** Sipariş toplamından %10 indirim uygulanır.
- **Kategori 2'ye ait bir üründen 6 adet satın alındığında:** Bir tanesi ücretsiz verilir.
- **Kategori 1'den iki veya daha fazla ürün satın alındığında:** En ucuz ürüne %20 indirim yapılır.
- Gelecekte eklenebilecek indirim kurallarına uygun şekilde yapı esneklik sağlar.

## API Kullanımı

### Sipariş İşlemleri
#### Sipariş Ekleme
**Endpoint:** `POST /api/orders`

**Kurallar:**
- Satın alınan ürünün stoğu yetersizse hata döner.

**Örnek İstek:**
```json
{
  "customer_id": 1,
  "products": [
    { "product_id": 2, "quantity": 3 },
    { "product_id": 5, "quantity": 1 }
  ]
}
```

### İndirim Hesaplama
**Endpoint:** `POST /api/orders/{id}/discounts`

#### Sipariş Listeleme
**Endpoint:** `GET /api/orders`

#### Sipariş Silme
**Endpoint:** `DELETE /api/orders/{id}`

### Postman Collection
**Link:** `https://documenter.getpostman.com/view/42431356/2sB2cPj5CP`






