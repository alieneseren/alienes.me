# Otomata Teorisi - Ders Notları 2025

*Bu doküman Tokat Gaziosmanpaşa Üniversitesi Bilgisayar Mühendisliği Bölümü Otomata Teorisi dersi için hazırlanmıştır.*

---

## 📚 Ders İçeriği

### 1. Hafta - Giriş ve Genel Kavramlar
- Otomata Teorisinin Tanımı ve Kapsamı
- Zihin ve Makine
- Kurallar ve Özgürlük
- Dil ve Anlam
- Temel Kavramlar: Alfabe, Kelime, Dil

### 2. Hafta - Düzenli İfadeler
- Düzenli İfadelerin Tanımı
- Düzenli İfadelerin Operatörleri
- Düzenli Diller
- Düzenli İfadelerin Özellikleri

### 3. Hafta - Sonlu Otomatlar
- Sonlu Otomatların Tanımı
- Deterministik Sonlu Otomatlar (DFA)
- Deterministik Olmayan Sonlu Otomatlar (NFA)
- Geçiş Diyagramları ve Geçiş Tabloları

### 4. Hafta - Düzenli Dillerin Özellikleri
- Düzenli Dillerin Kapalılık Özellikleri
- Düzenli Dillerin Karar Özellikleri

### 5. Hafta - Bağlamdan Bağımsız Gramerler
- Bağlamdan Bağımsız Gramerlerin Tanımı
- Bağlamdan Bağımsız Diller
- Belirsizlik Kavramı

### 6. Hafta - İtmeli Otomatlar (Pushdown Automata)
- İtmeli Otomatların Tanımı
- İtmeli Otomatlar ve Bağlamdan Bağımsız Gramerlerin Denkliği

### 7. Hafta - Bağlamdan Bağımsız Gramerler Üzerindeki İşlemler
- Gramer Dönüşümleri
- Chomsky Normal Formu

### 8. Hafta - Turing Makineleri
- Turing Makinelerinin Tanımı
- Turing Makinelerinin Güçlülüğü
- Hesaplanabilirlik Kavramı

### 9. Hafta - Farklı Turing Makine Modelleri
- Çok Bantlı Turing Makineleri
- Deterministik Olmayan Turing Makineleri

### 10. Hafta - Karar Verilebilirlik
- Karar Verilen Problemler
- Karar Verilemeyen Problemler

### 11. Hafta - NP-Tam Problemler
- P ve NP Sınıfları
- NP-Tamlığın Önemi

---

## 🔤 1. Temel Kavramlar

### Alfabe (Alphabet)
Kelimelerin üretiminde kullanılan birimlerin sonlu kümesine **alfabe** denir. Alfabenin elemanları genelde "sembol" veya "harf" olarak adlandırılmaktadır. Alfabe genelde Σ sembolü ile gösterilmektedir.

**Örnekler:**
- Σ = {a,b,c,ç,...,z,A,B,C,Ç,...,Z} → Türkçe alfabesi
- Σ = {0,1,2,...,9} → Rakamlar alfabesi
- Σ = {0,1} → İkili sistem alfabesi

### Kelime (Word)
Kelime, Σ alfabesinden seçilen sonlu sayıdaki sembolün bir araya gelmesinden oluşmaktadır.

**Örnekler:**
- Σ = {a,b} için: a, b, aa, ab, ba, bb, aaa, vb.

### Dil (Language)
Bir alfabe üzerinden üretilmiş olan kelimelerin kümesi **dil** olarak adlandırılır. Dile ait olan kelimelerin nasıl üretileceğinin kuralları tanımlanmış ise söz konusu dil **biçimsel (formal) dil** olarak adlandırılmaktadır.

**Örnekler:**
- L₁ = {a, aa, aaa, aaaa, ...} → a harfinden oluşan tüm kelimeler
- L₂ = {ab, abb, abbb, abbbb, ...} → ab ile başlayan ve sonrasında b'ler gelen kelimeler

---

## 🔄 2. Düzenli İfadeler (Regular Expressions)

Düzenli ifade (regular expression), dil tanımlayıcı ifadedir. Düzenli ifadeler ile tanımlanan diller **düzenli diller (regular languages)** olarak adlandırılmaktadır.

### Düzenli İfadelerin Operatörleri

1. **Birleştirme (Concatenation)**: xy
2. **Birleşim (Union)**: x|y veya x+y
3. **Yıldız (Kleene Star)**: x*
4. **Artı (Kleene Plus)**: x+
5. **Parantez**: (x)

### Düzenli İfade Kuralları

- ε (epsilon): Boş kelime
- ∅ (phi): Boş dil
- Eğer a ∈ Σ ise, a düzenli ifadedir
- Eğer r ve s düzenli ifadeler ise:
  - (r)(s) = rs düzenli ifadedir
  - (r)|(s) = r+s düzenli ifadedir
  - (r)* düzenli ifadedir

### Örnekler

**Örnek 1:** Σ={x} olmak üzere, L={ε, x, xx, xxx, xxxx, .....} kümesi
- Düzenli ifade: x*

**Örnek 2:** Σ={a,b} olmak üzere, L={a, ab, abb, abbb, abbbb, .....}
- Düzenli ifade: ab*

**Örnek 3:** Σ={a,b} olmak üzere, L={ε, ab, abab, ababab, ......}
- Düzenli ifade: (ab)*

**Örnek 4:** Σ={a,b} olmak üzere, L={a, b, aa, ab, ba, bb, aaa, ...}
- Düzenli ifade: (a|b)*

---

## 🤖 3. Sonlu Otomatlar (Finite Automata)

### Tanım
Sonlu otomata (finite automata), durumları (states) içeren bir küme ve dışsal girdilere göre bu durumlar arasında gerçekleşen geçişlerden oluşmaktadır.

Belli bir girdiye ilişkin olarak, belli bir durumdan sadece tek bir çıkış varsa söz konusu sonlu otomata **deterministik** olarak adlandırılır. Bu kurala uymayan otomatalar, **deterministik değildir (non-deterministic)**.

### Biçimsel Tanım
Bir deterministik sonlu otomata, **M=(Q, Σ, δ, s, F)** biçiminde belirtilen bir beşli ile ifade edilmektedir:

- **Q**: Durumlara ilişkin sembollerden oluşan küme (durumlar alfabesi)
- **Σ**: Girdi sembollerinin alfabesi (input alphabet)
- **δ**: Q × Σ → Q olmak üzere geçiş fonksiyonu (transition function)
- **s ∈ Q**: Başlangıç durumu (start state)
- **F ⊆ Q**: Sonuç durumları kümesi (final states)

### Gösterim Yöntemleri

#### Geçiş Diyagramı (Transition Diagram)
- Durumlar yuvarlak/oval şekillerle gösterilir
- Başlangıç durumu okla gösterilir
- Kabul durumları çift çemberle gösterilir
- Geçişler etiketli oklarla gösterilir

#### Geçiş Tablosu (Transition Table)
- Satırlar durumları, sütunlar girdi sembollerini gösterir
- Hücreler hedef durumları gösterir

### Örnek DFA
```
M = (Q, Σ, δ, s, F)
Q = {q₀, q₁, q₂}
Σ = {a, b}
δ(q₀,a) = q₁, δ(q₀,b) = q₀
δ(q₁,a) = q₂, δ(q₁,b) = q₁
δ(q₂,a) = q₂, δ(q₂,b) = q₂
s = q₀
F = {q₂}
```

Bu DFA, "a" ile başlayan ve en az bir "a" içeren tüm dizgileri kabul eder.

---

## 📝 4. Otomat Örnekleri

### Örnek 1: Geçiş Tablosu Analizi
Girdi alfabesi Σ={a, b, c} olan 4 durumlu bir sonlu durum otomati aşağıdaki geçiş tablosuyla verilmiştir:

|   | a  | b  | c  |
|---|---|---|---|
| q₁ | q₂ | q₃ | q₁ |
| q₂ | q₂ | q₄ | q₁ |
| q₃ | q₄ | q₃ | q₁ |
| q₄ | q₄ | q₄ | q₄ |

**Çözüm:**
- Başlangıç durumu: q₁
- Kabul durumları: q₄ (çift çember)
- Bu otomat, "ab" veya "ba" durumları olmayan veya a ile b arasında en az bir c bulunan dizgileri kabul eder.

### Örnek 2: 01 ile Biten Dizgiler
Girdi alfabesi Σ={0, 1} olan ve 01 ile biten sonlu durum otomatı:

```
q₀ --0--> q₀
q₀ --1--> q₁
q₁ --0--> q₂
q₁ --1--> q₁
q₂ --0--> q₀
q₂ --1--> q₁
```

Kabul durumu: q₂

### Örnek 3: Aynı Sembolle Başlayıp Biten Dizgiler
Σ={0, 1} için aynı sembolle başlayıp biten dizgiler:

```
q₀ --0--> q₁
q₀ --1--> q₂
q₁ --0--> q₁
q₁ --1--> q₃
q₂ --0--> q₄
q₂ --1--> q₂
q₃ --0--> q₃
q₃ --1--> q₃
q₄ --0--> q₄
q₄ --1--> q₄
```

Kabul durumları: q₁, q₂

### Örnek 4: n+m=3 Koşulu
Σ={a, b}, L = {w | w = aⁿbᵐ, n+m=3} için DFA:

```
q₀ --a--> q₁
q₀ --b--> q₃
q₁ --a--> q₂
q₁ --b--> q₄
q₂ --a--> q₅
q₂ --b--> q₆
q₃ --a--> q₇
q₃ --b--> q₈
q₄ --a--> q₉
q₄ --b--> q₁₀
q₅ --a--> q₁₁
q₅ --b--> q₁₂
q₆ --a--> q₁₃
q₆ --b--> q₁₄
```

Kabul durumları: n+m=3 olan durumlar

### Örnek 5: 00 ve 11 İçermeyen Dizgiler
Σ={0, 1} için 00 ve 11 içermeyen dizgiler:

```
q₀ --0--> q₁
q₀ --1--> q₂
q₁ --0--> q₃ (red)
q₁ --1--> q₂
q₂ --0--> q₁
q₂ --1--> q₃ (red)
q₃ --0--> q₃
q₃ --1--> q₃
```

Kabul durumları: q₀, q₁, q₂

### Örnek 6: En Çok İki a İçeren Dizgiler
Σ={a, b} için en çok iki a içeren dizgiler:

```
q₀ --a--> q₁
q₀ --b--> q₀
q₁ --a--> q₂
q₁ --b--> q₁
q₂ --a--> q₃ (red)
q₂ --b--> q₂
q₃ --a--> q₃
q₃ --b--> q₃
```

Kabul durumları: q₀, q₁, q₂

### Örnek 7: n,m ≥ 1 Koşulu
Σ={a, b}, L = {w | w = aⁿbᵐ, n,m ≥ 1} için DFA:

```
q₀ --a--> q₁
q₀ --b--> q₃ (red)
q₁ --a--> q₁
q₁ --b--> q₂
q₂ --a--> q₄ (red)
q₂ --b--> q₂
q₃ --a--> q₃
q₃ --b--> q₃
q₄ --a--> q₄
q₄ --b--> q₄
```

Kabul durumu: q₂

---

## 🎯 5. Önemli Kavramlar ve Kurallar

### Otomata Teorisinin Uygulama Alanları
- **Derleyici Tasarımı**: Programlama dillerinin yapılarının tanınması
- **Doğal Dil İşleme**: Dil yapılarının formel analizi
- **Veritabanı Arama**: Düzenli ifadeler ve metin arama
- **Ağ Güvenliği**: Pattern matching ve intrusion detection
- **Bioinformatics**: DNA dizilim analizi

### Düzenli Dil Özellikleri
1. **Kapalılık**: Düzenli diller birleşim, birleştirme ve yıldız işlemlerine kapalıdır
2. **Karar Özelliği**: Verilen bir düzenli ifade için üyelik sorunu karar verilebilir
3. **Pomping Lemma**: Düzenli diller için pomping lemma geçerlidir

### DFA vs NFA
- **DFA**: Her durum için her girdi sembolü için tam olarak bir geçiş
- **NFA**: Bir durum için bir girdi sembolü için birden fazla geçiş veya ε-geçiş olabilir
- **Denklik**: Her NFA'nın eşdeğer bir DFA'sı vardır (üssel durum artışı ile)

### Turing Makinesi Özellikleri
- **En güçlü otomat**: Her hesaplanabilir fonksiyonu hesaplayabilir
- **Halt problemi**: Genel olarak durma sorunu karar verilemez
- **Church-Turing Tezi**: Hesaplanabilirlik = Turing hesaplanabilir

---

## 📚 Kaynaklar

1. Hopcroft, J.E., Motwani, R., & Ullman, J.D. (2006). Introduction to Automata Theory, Languages, and Computation.
2. Sipser, M. (2012). Introduction to the Theory of Computation.
3. Tokat Gaziosmanpaşa Üniversitesi Bilgisayar Mühendisliği Bölümü Ders Notları.

---

*Bu doküman eğitim amaçlı hazırlanmıştır. Ticari kullanım için izin alınması gerekir.*