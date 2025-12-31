# Ders_1.pdf

*Bu doküman PDF'den otomatik olarak dönüştürülmüştür.*

---

## Sayfa 1

OTOMATA TEORİSİ

---

## Sayfa 2

2.HAFTA
• Genel tanımlar
• 3.HAFTA
• Düzenli İfadeler
4.HAFTA
• Düzenli Dillerin Özellikleri
5.HAFTA
• Düzenli Dillerin Karar Özellikleri
6.HAFTA
• Bağlamdan Bağımsız Gramerler ve Belirsizlik
• 7.HAFTA
HAFTALARA GÖRE İŞLENECEK KONULAR

---

## Sayfa 3

7.HAFTA
• İtmeli Otomatlar
8.HAFTA
• İtmeli Otomatlar ve Bağlamdan Bağımsız Gramerlerin Denkliği
9.HAFTA
• Bağlamdan Bağımsız Gramerler Üzerindeki İşlemler
10.HAFTA
• Bağlamdan Bağımsız Gramerlerin Kapalılık Özellikleri
11.HAFTA
• Turing Makinaları ve Karmaşıklık
12. HAFTA
• Farklı Turing Makine Modelleri
13. HAFTA
• Karar Verilen ve Verilemeyen Problemler
14. HAFTA
• NP-Tam Problemler
HAFTALARA GÖRE İŞLENECEK KONULAR

---

## Sayfa 4

Zihin ve Makine
İnsanlar gibi düşünebilen bir makine yapılabilir mi?

---

## Sayfa 5

• Otomata teorisi, “düşünebilen” sistem fikrinin temelinde yatan kural-
tabanlı işlemeyi inceler.
• Bir makine, belirli girdileri alıp durum geçişleri ile çıktılar üretir; 
karmaşık davranışlar bile basit kuralların birleşimi ile ortaya çıkabilir.
• “Düşünebilme” iddiası felsefidir; fakat hesaplanabilir olanın sınırları 
otomata teorisi ve Turing makineleriyle formel olarak tartışılır.
Örneğin;
• Satranç motorları, dil modelleri, öneri sistemleri → hepsi 
kural/öğrenilmiş kural + durum geçişleri mantığında işler.

---

## Sayfa 6

Kurallar ve Özgürlük
Hayatımız tamamen kurallarla yönetiliyor olsaydı, seçim özgürlüğümüz olur 
muydu?


---

## Sayfa 7

• Otomatlar katı kurallarla çalışır ama buna rağmen çok çeşitli 
davranışlar üretebilir.
• Deterministik sistemlerde bile, farklı girdiler ve başlangıç durumları 
farklı yollar doğurur.
• Tasarımcının seçtiği durumlar, geçişler ve girişler aslında “özgürlük 
alanını” belirler.
Örneğin;
• ATM, asansör, oyun menüsü: Hepsi sonlu durum makinesi; özgürlük, 
izin verilen geçişlerin çeşitliliği kadardır.

---

## Sayfa 8

Dil ve Anlam
Bir bilgisayar dili gerçekten ‘anlayabilir’ mi, yoksa sadece sembolleri işler mi?


---

## Sayfa 9

• Otomata teorisi, dilleri biçimsel olarak ele alır: alfabe, kelime, dil, 
kabul edici.
• Makine, anlamdan ziyade yapıyı kontrol eder (ör. düzenli diller için 
DFA).
• “Anlam” felsefi ve anlambilimsel bir mesele; fakat hangi yapıları 
tanıyabileceğimizi otomata sınıfları net biçimde sınırlar.
Örneğin;
• Yazım denetimi/regex arama → sonlu otomat; parantez dengeleme 
→ yığıtlı otomat; genel hesaplama → Turing makinesi.

---

## Sayfa 10

Otomata Teorisinin Tanımı ve Kapsamı
Otomata Teorisi, hesaplama makinelerinin (otomataların) davranışlarını ve bu makinelerin hangi 
tür problemleri çözebileceğini inceleyen matematiksel bir alandır. Temel olarak, otomatalar 
aracılığıyla çeşitli dil türleri ve bu dillerin tanımlanabilirliği araştırılır.
Giriş
Otomata: Belirli kurallara göre giriş alıp, bu girişlere karşılık çıktılar üreten soyut makineler. En 
yaygın otomata türleri arasında Sonlu Otomatlar (DFA ve NFA), Yığıtlı Otomatlar (PDA) ve Turing 
Makineleri bulunmaktadır.
Otomata Türleri
•Sonlu Otomatlar (Finite Automata): Sınırlı bellek kapasitesine sahip otomatalar olup, düzenli 
dilleri tanımlarlar. Deterministik (DFA) ve Deterministik Olmayan (NFA) olmak üzere iki çeşidi 
bulunur.
•Yığıtlı Otomatlar (Pushdown Automata): Ekstra bir yığıt belleğe sahip olup, bağlamdan bağımsız 
dilleri tanırlar.
•Turing Makineleri: Daha güçlü otomatalar olup, herhangi bir hesaplanabilir problemi çözebilirler. 
Hesaplanabilirlik ve karar verilebilirlik konularında temel rol oynarlar.

---

## Sayfa 11

Otomata Teorisinin Modern Uygulama Alanları
Bugün, otomata teorisi bilgisayar bilimlerinde çok geniş bir kullanım 
alanına sahiptir:
•Derleyici Tasarımı: Otomatalar, programlama dillerinin yapılarının 
tanınmasında ve analiz edilmesinde kullanılır.
•Doğal Dil İşleme: Otomata teorisi, doğal dilin formel yapılarının analiz 
edilmesi ve işlenmesinde rol oynar.
•Veritabanı Arama: Düzenli ifadeler ve sonlu otomatalar, metin arama 
ve veri işleme işlemlerinde sıkça kullanılır.

---

## Sayfa 12

İkinci Dünya Savaşı ve Alan Turing

---

## Sayfa 13

ALFABE(Alphabet)
TEMEL KA VRAMLAR
KELİME(Word) DİL(Language)

---

## Sayfa 14

ALFABE(Alphabet)
TEMEL KA VRAMLAR
KELİME(Word) DİL(Language)

---

## Sayfa 15

ALFABE(Alphabet)
TEMEL KA VRAMLAR
KELİME(Word) DİL(Language)
Kelimelerin üretiminde kullanılan
birimlerin sonlu kümesine alfabe
denir. Alfabenin elemanları genelde
"sembol" veya "harf" olarak
adlandırılmaktadır. Alfabe genelde 
sembolü ile gösterilmektedir
 ={a,b,c,ç,.......,z,A,B,C,Ç,..........Z} ile
gösterilen alfabe Türkçe kelimelerin
oluşturulması için gereken sembolleri
içeren örnek bir alfabedir.
={0,1,2,......9} ile gösterilen alfabe
çeşitli tamsayılar oluşturmak amacıyla
kullanılabilecek bir alfabedir.

---

## Sayfa 16

ALFABE(Alphabet)
TEMEL KA VRAMLAR
KELİME(Word) DİL(Language)
Kelimelerin üretiminde kullanılan
birimlerin sonlu kümesine alfabe
denir. Alfabenin elemanları genelde
"sembol" veya "harf" olarak
adlandırılmaktadır. Alfabe genelde 
sembolü ile gösterilmektedir
 ={a,b,c,ç,.......,z,A,B,C,Ç,..........Z} ile
gösterilen alfabe Türkçe kelimelerin
oluşturulması için gereken sembolleri
içeren örnek bir alfabedir.
={0,1,2,......9} ile gösterilen alfabe
çeşitli tamsayılar oluşturmak amacıyla
kullanılabilecek bir alfabedir.

---

## Sayfa 17

ALFABE(Alphabet)
TEMEL KA VRAMLAR
KELİME(Word) DİL(Language)
Kelimelerin üretiminde kullanılan
birimlerin sonlu kümesine alfabe
denir. Alfabenin elemanları genelde
"sembol" veya "harf" olarak
adlandırılmaktadır. Alfabe genelde 
sembolü ile gösterilmektedir
 ={a,b,c,ç,.......,z,A,B,C,Ç,..........Z} ile
gösterilen alfabe Türkçe kelimelerin
oluşturulması için gereken sembolleri
içeren örnek bir alfabedir.
={0,1,2,......9} ile gösterilen alfabe
çeşitli tamsayılar oluşturmak amacıyla
kullanılabilecek bir alfabedir.
Kelime,  alfabesinden seçilen sonlu
sayıdaki sembolün bir araya
gelmesinden oluşmaktadır.

---

## Sayfa 18

ALFABE(Alphabet)
TEMEL KA VRAMLAR
KELİME(Word) DİL(Language)
Kelimelerin üretiminde kullanılan
birimlerin sonlu kümesine alfabe
denir. Alfabenin elemanları genelde
"sembol" veya "harf" olarak
adlandırılmaktadır. Alfabe genelde 
sembolü ile gösterilmektedir
 ={a,b,c,ç,.......,z,A,B,C,Ç,..........Z} ile
gösterilen alfabe Türkçe kelimelerin
oluşturulması için gereken sembolleri
içeren örnek bir alfabedir.
={0,1,2,......9} ile gösterilen alfabe
çeşitli tamsayılar oluşturmak amacıyla
kullanılabilecek bir alfabedir.
Kelime,  alfabesinden seçilen sonlu
sayıdaki sembolün bir araya
gelmesinden oluşmaktadır.
Örnek Kelimeler 
 ={a,b,c,ç,.......,z,A,B,C,Ç,..........Z} 
alfebesinden üretilen kelimeler:  Ahmed, 
mehmed, fatih, aaaG, 
={0,1,2,......9} alfebesinden üretilen kelimeler:
1234,0945,345102, 670, 0,9
Boş kelime (empty word), her alfabe üzerinden
geçerli olan bir kelimedir ve  sembolü ile
gösterilmektedir. Buradaki önemli nokta, 
sembolünün alfabenin elemanı olmamasıdır: 


---

## Sayfa 19

ALFABE(Alphabet)
TEMEL KA VRAMLAR
KELİME(Word) DİL(Language)
Kelimelerin üretiminde kullanılan
birimlerin sonlu kümesine alfabe
denir. Alfabenin elemanları genelde
"sembol" veya "harf" olarak
adlandırılmaktadır. Alfabe genelde 
sembolü ile gösterilmektedir
 ={a,b,c,ç,.......,z,A,B,C,Ç,..........Z} ile
gösterilen alfabe Türkçe kelimelerin
oluşturulması için gereken sembolleri
içeren örnek bir alfabedir.
={0,1,2,......9} ile gösterilen alfabe
çeşitli tamsayılar oluşturmak amacıyla
kullanılabilecek bir alfabedir.
Kelime,  alfabesinden seçilen sonlu
sayıdaki sembolün bir araya
gelmesinden oluşmaktadır.
Örnek Kelimeler 
 ={a,b,c,ç,.......,z,A,B,C,Ç,..........Z} 
alfebesinden üretilen kelimeler:  Ahmed, 
mehmed, fatih, aaaG, 
={0,1,2,......9} alfebesinden üretilen kelimeler:
1234,0945,345102, 670, 0,9
Boş kelime (empty word), her alfabe üzerinden
geçerli olan bir kelimedir ve  sembolü ile
gösterilmektedir. Buradaki önemli nokta, 
sembolünün alfabenin elemanı olmamasıdır: 


---

## Sayfa 20

ALFABE(Alphabet)
TEMEL KA VRAMLAR
KELİME(Word) DİL(Language)
Kelimelerin üretiminde kullanılan
birimlerin sonlu kümesine alfabe
denir. Alfabenin elemanları genelde
"sembol" veya "harf" olarak
adlandırılmaktadır. Alfabe genelde 
sembolü ile gösterilmektedir
 ={a,b,c,ç,.......,z,A,B,C,Ç,..........Z} ile
gösterilen alfabe Türkçe kelimelerin
oluşturulması için gereken sembolleri
içeren örnek bir alfabedir.
={0,1,2,......9} ile gösterilen alfabe
çeşitli tamsayılar oluşturmak amacıyla
kullanılabilecek bir alfabedir.
Kelime,  alfabesinden seçilen sonlu
sayıdaki sembolün bir araya
gelmesinden oluşmaktadır.
Örnek Kelimeler 
 ={a,b,c,ç,.......,z,A,B,C,Ç,..........Z} 
alfebesinden üretilen kelimeler:  Ahmed, 
mehmed, fatih, aaaG, 
={0,1,2,......9} alfebesinden üretilen kelimeler:
1234,0945,345102, 670, 0,9
Boş kelime (empty word), her alfabe üzerinden
geçerli olan bir kelimedir ve  sembolü ile
gösterilmektedir. Buradaki önemli nokta, 
sembolünün alfabenin elemanı olmamasıdır: 

Bir alfabe üzerinden üretilmiş olan  
kelimelerin kümesi dildir.
Dile ait olan kelimelerin nasıl 
üretileceğinin kuralları tanımlanmış ise 
söz konusu dil biçimsel (formal) dil olarak 
adlandırılmaktadır
Bir dili tanımlamak için iki bileşenin
tanımı gerekmektedir:
1. Bir alfabe tanımlanması.
2. Hangi kelimelerin dildeki geçerli
kelimeler olduğunu belirten kuralların
tanımlanması.

---

## Sayfa 21

ALFABE(Alphabet)
TEMEL KA VRAMLAR
KELİME(Word) DİL(Language)
Kelimelerin üretiminde kullanılan
birimlerin sonlu kümesine alfabe
denir. Alfabenin elemanları genelde
"sembol" veya "harf" olarak
adlandırılmaktadır. Alfabe genelde 
sembolü ile gösterilmektedir
 ={a,b,c,ç,.......,z,A,B,C,Ç,..........Z} ile
gösterilen alfabe Türkçe kelimelerin
oluşturulması için gereken sembolleri
içeren örnek bir alfabedir.
={0,1,2,......9} ile gösterilen alfabe
çeşitli tamsayılar oluşturmak amacıyla
kullanılabilecek bir alfabedir.
Kelime,  alfabesinden seçilen sonlu
sayıdaki sembolün bir araya
gelmesinden oluşmaktadır.
Örnek Kelimeler 
 ={a,b,c,ç,.......,z,A,B,C,Ç,..........Z} 
alfebesinden üretilen kelimeler:  Ahmed, 
mehmed, fatih, aaaG, 
={0,1,2,......9} alfebesinden üretilen kelimeler:
1234,0945,345102, 670, 0,9
Boş kelime (empty word), her alfabe üzerinden
geçerli olan bir kelimedir ve  sembolü ile
gösterilmektedir. Buradaki önemli nokta, 
sembolünün alfabenin elemanı olmamasıdır: 

Bir alfabe üzerinden üretilmiş olan  
kelimelerin kümesi dildir.
Dile ait olan kelimelerin nasıl 
üretileceğinin kuralları tanımlanmış ise 
söz konusu dil biçimsel (formal) dil olarak 
adlandırılmaktadır
Bir dili tanımlamak için iki bileşenin
tanımı gerekmektedir:
1. Bir alfabe tanımlanması.
2. Hangi kelimelerin dildeki geçerli
kelimeler olduğunu belirten kuralların
tanımlanması.
={x} ve L1={xn , n=1,2,3,...}
Örnek kelimeler?

---

## Sayfa 22

ALFABE(Alphabet)
TEMEL KA VRAMLAR
KELİME(Word) DİL(Language)
Kelimelerin üretiminde kullanılan
birimlerin sonlu kümesine alfabe
denir. Alfabenin elemanları genelde
"sembol" veya "harf" olarak
adlandırılmaktadır. Alfabe genelde 
sembolü ile gösterilmektedir
 ={a,b,c,ç,.......,z,A,B,C,Ç,..........Z} ile
gösterilen alfabe Türkçe kelimelerin
oluşturulması için gereken sembolleri
içeren örnek bir alfabedir.
={0,1,2,......9} ile gösterilen alfabe
çeşitli tamsayılar oluşturmak amacıyla
kullanılabilecek bir alfabedir.
Kelime,  alfabesinden seçilen sonlu
sayıdaki sembolün bir araya
gelmesinden oluşmaktadır.
Örnek Kelimeler 
 ={a,b,c,ç,.......,z,A,B,C,Ç,..........Z} 
alfebesinden üretilen kelimeler:  Ahmed, 
mehmed, fatih, aaaG, 
={0,1,2,......9} alfebesinden üretilen kelimeler:
1234,0945,345102, 670, 0,9
Boş kelime (empty word), her alfabe üzerinden
geçerli olan bir kelimedir ve  sembolü ile
gösterilmektedir. Buradaki önemli nokta, 
sembolünün alfabenin elemanı olmamasıdır: 

Bir alfabe üzerinden üretilmiş olan  
kelimelerin kümesi dildir.
Dile ait olan kelimelerin nasıl 
üretileceğinin kuralları tanımlanmış ise 
söz konusu dil biçimsel (formal) dil olarak 
adlandırılmaktadır
Bir dili tanımlamak için iki bileşenin
tanımı gerekmektedir:
1. Bir alfabe tanımlanması.
2. Hangi kelimelerin dildeki geçerli
kelimeler olduğunu belirten kuralların
tanımlanması.
={x} ve L1={xn , n=1,2,3,...}
Örnek kelimeler?
={x,y} ve L1={xn yn, n=1,2,3,...}
Örnek kelimeler?

---

## Sayfa 23

KELİME İŞLEMLERİ
TEMEL KA VRAMLAR
Birleştirme (Concatenation)
Uzunluk (Length) Fonksiyonu
Ters (Reverse) Fonksiyonu
Önek (Prefix)
Sonek (Suffix)
Alt Kelime (Subword)

---

## Sayfa 24

KELİME İŞLEMLERİ
TEMEL KA VRAMLAR
Birleştirme (Concatenation)
 alfabesi üzerinde tanımlı w1 ve w2 gibi iki kelime olduğu varsayıldığında, w1
kelimesinin w2 kelimesi ile birleştirilmesi (concatenation), w2 kelimesinin w1
kelimesinin sonuna eklenmesi ile oluşmakta ve w1w2 olarak gösterilmektedir.
İki boş kelimenin birleştirilmesi boş kelimedir: = .
w=w yazılabilecektir
Örnekler:
K1=aabba, K2=abab
K1K2=aabbaabab
• L1={x,xx,xxx,xxxx,.........} dili için birleştirme işlemi geçerlidir. Örneğin, xx  L1 ve
xxx L1 olmak üzere, bu iki kelimenin birleştirilmesi ile oluşan xxxxx kelimesi L1
dilinin elemanıdır.

---

## Sayfa 25

KELİME İŞLEMLERİ
TEMEL KA VRAMLAR
Birleştirme (Concatenation)
 alfabesi üzerinde tanımlı w1 ve w2 gibi iki kelime olduğu varsayıldığında, w1
kelimesinin w2 kelimesi ile birleştirilmesi (concatenation), w2 kelimesinin w1
kelimesinin sonuna eklenmesi ile oluşmakta ve w1w2 olarak gösterilmektedir.
İki boş kelimenin birleştirilmesi boş kelimedir: = .
w=w yazılabilecektir
Örnekler:
K1=aabba, K2=abab
K1K2=aabbaabab
• L1={x,xx,xxx,xxxx,.........} dili için birleştirme işlemi geçerlidir. Örneğin, xx  L1 ve
xxx L1 olmak üzere, bu iki kelimenin birleştirilmesi ile oluşan xxxxx kelimesi L1
dilinin elemanıdır.
• Soru: L2={x2n+1 , n=0,1,2,3,.....} için birleştirme işlemi geçerli midir?

---

## Sayfa 26

KELİME İŞLEMLERİ
TEMEL KA VRAMLAR
w kelimesi bir dile ilişkin kelime olmak üzere, w kelimesindeki sembollerin sondan
başa doğru yazılması ile oluşan yeni kelime denir. ters(w) veya wR olarak
gösterilmektedir.
Örneğin,
w=abba ters(w)=abba
w=aaab ters(w)=baaa
w=145 ters(w)=541'dir.
Ters (Reverse) Fonksiyonu

---

## Sayfa 27

KELİME İŞLEMLERİ
TEMEL KA VRAMLAR
w kelimesi bir dile ilişkin kelime olmak üzere, w kelimesindeki sembollerin sondan
başa doğru yazılması ile oluşan yeni kelime denir. ters(w) veya wR olarak
gösterilmektedir.
Örneğin,
w=abba ters(w)=abba
w=aaab ters(w)=baaa
w=145 ters(w)=541'dir.
Ters (Reverse) Fonksiyonu
Soru: Ters fonksiyonu sonucunda elde edilen kelimenin dilin elemanı olmama
olasılığı varmıdır?

---

## Sayfa 28

KELİME İŞLEMLERİ
TEMEL KA VRAMLAR
Bir dile ait w1 kelimesinin uzunluğu, o kelimedeki sembol sayısına eşittir ve |w1|
olarak gösterilmektedir.
Örneğin,
w=abba |w|=4
w=aaaba |w|=5
w=010101 |w|=6
Uzunluk (Length) Fonksiyonu
w= aaaba | w |=?
w= aaaba | w |=?
| |=?

---

## Sayfa 29

KELİME İŞLEMLERİ
TEMEL KA VRAMLAR
Bir dile ait w1 kelimesinin uzunluğu, o kelimedeki sembol sayısına eşittir ve |w1|
olarak gösterilmektedir.
Örneğin,
w=abba |w|=4
w=aaaba |w|=5
w=010101 |w|=6
Uzunluk (Length) Fonksiyonu
w= aaaba | w |=5
w= aaaba | w |=5
| |=0

---

## Sayfa 30

KELİME İŞLEMLERİ
TEMEL KA VRAMLAR
Eğer t ve z bir alfabe üzerinden tanımlı kelimeler ise ve tw1z=w2 geçerli ise w1
kelimesi w2 kelimesinin alt kelimesidir (subword).
Türkçe dilinden örnek verilecek olursa, “afyonkarahisar” kelimesi, “afyon” , “kara” 
ve “hisar” şeklinde parçalanabilecektir. 
"substring" kelimesinin alt kelimesi "string" ,olabilir
Örneğin,
"apple kelimesinin alt kelimeleri
"apple", "appl", "pple", "app", "ppl", "ple", "ap", "pp", "pl", "le", "a", "p", "l", "e",
""
Alt Kelime (Subword)

---

## Sayfa 31

KELİME İŞLEMLERİ
TEMEL KA VRAMLAR
• Eğer z,  üzerinde tanımlı bir kelime ise ve w1z=w2 ise w1 kelimesi w2
kelimesinin öneki (prefix) olarak adlandırılmaktadır.
• Boş kelime her kelimenin önekidir
Örneğin,
İngilizce dilindeki, “disagree” kelimesinde ön ek “dis” kelimesidir.
«banana» ön eki «ban»
Önek (Prefix)

---

## Sayfa 32

KELİME İŞLEMLERİ
TEMEL KA VRAMLAR
• Eğer z,  üzerinde tanımlı bir kelime ise ve zw1=w2 ise w1 kelimesi w2
kelimesinin soneki (suffix) olarak adlandırılmaktadır.
• Örneğin, w1=ing w2=playing ve z=play ise w1 kelimesi olan “ing” w2 kelimesi
olan “playing” ’in sonekidir.
Sonek (Suffix)

---

## Sayfa 33

KELİME İŞLEMLERİ
TEMEL KA VRAMLAR
• For example, let 𝑤= 𝑎𝑏𝑎𝑎be a string over Σ = {𝑎, 𝑏}.
Its prefixes, suffixes and substrings are as follows:
• Prefixes: , 𝑎, 𝑎𝑏, 𝑎𝑏𝑎, 𝑎𝑏𝑎𝑎.
• Suffixes: , 𝑎, 𝑎𝑎, 𝑏𝑎𝑎, 𝑎𝑏𝑎𝑎.
• Substrings: , 𝑎, 𝑏, 𝑎𝑏, 𝑎, 𝑏𝑎, 𝑎𝑏𝑎, 𝑎, 𝑎𝑎, 𝑏𝑎𝑎, 𝑎𝑏𝑎𝑎.
Örnekler

---

## Sayfa 34

KELİME İŞLEMLERİ
TEMEL KA VRAMLAR
• For example, let 𝑤= 𝑎𝑏𝑎𝑎be a string over Σ = {𝑎, 𝑏}.
Its prefixes, suffixes and substrings are as follows:
• Prefixes: , 𝑎, 𝑎𝑏, 𝑎𝑏𝑎, 𝑎𝑏𝑎𝑎.
• Suffixes: , 𝑎, 𝑎𝑎, 𝑏𝑎𝑎, 𝑎𝑏𝑎𝑎.
• Substrings: , 𝑎, 𝑏, 𝑎𝑏, 𝑎, 𝑏𝑎, 𝑎𝑏𝑎, 𝑎, 𝑎𝑎, 𝑏𝑎𝑎, 𝑎𝑏𝑎𝑎.
Örnekler
• X=through kelimesi için tüm önek, sonek ve alt kelimeleri yazınız?
• Önekler:
• Sonekler:
• Alt Kelimeler:

---

## Sayfa 35

KELİME İŞLEMLERİ
TEMEL KA VRAMLAR
• For example, let 𝑤= 𝑎𝑏𝑎𝑎be a string over Σ = {𝑎, 𝑏}.
Its prefixes, suffixes and substrings are as follows:
• Prefixes: , 𝑎, 𝑎𝑏, 𝑎𝑏𝑎, 𝑎𝑏𝑎𝑎.
• Suffixes: , 𝑎, 𝑎𝑎, 𝑏𝑎𝑎, 𝑎𝑏𝑎𝑎.
• Substrings: , 𝑎, 𝑏, 𝑎𝑏, 𝑎, 𝑏𝑎, 𝑎𝑏𝑎, 𝑎, 𝑎𝑎, 𝑏𝑎𝑎, 𝑎𝑏𝑎𝑎.
Örnekler
• X=through kelimesi için tüm önek, sonek ve alt kelimeleri yazınız?
• Önekler:,t,th,thr,thro,throu,throug,through
• Sonekler: ,h,gh,ugh,ough,rough,hrough,through
• Alt Kelimeler:
,t,h,r,o,u,g,th,hr,ro,ou,ug,gh,thr,hro,rou,ugh,thro,hrou,roug,ough,throu,hroug,
rough,throug,hrough, through

---

## Sayfa 36

Alfabenin derecesi ve Kleene Star
TEMEL KA VRAMLAR
={0,1} ise,
0={ }
1={0,1}
2={00, 01, 10, 11}
3 = {000, 001, 010, 011, 100, 101, 110, 111 } şeklindeki kümeler alfabenin
kuvvetleri olarak adlandırılmaktadır.
•  alfabesi üzerinden tanımlanabilecek tüm kelimelerin dili alfabenin kapalılığı
olarak adlandırılmakta ve * olarak gösterilmektedir.
• * sonsuz bir kümedir. *, aynı zamanda "Kleene Star" olarak da
adlandırılmaktadır.
• Diğer bir gösterimle, * = 0 1 2 ....... şeklinde gösterilebilecektir.
• Örneğin, ={0,1} ise
*={, 0, 1, 00, 01, 10, 11, 000, 001, 010, 011, .....} olacaktır. 

---

## Sayfa 37

Alfabenin derecesi ve Kleene Star
TEMEL KA VRAMLAR
={0,1} ise,
0={ }
1={0,1}
2={00, 01, 10, 11}
3 = {000, 001, 010, 011, 100, 101, 110, 111 } şeklindeki kümeler alfabenin
kuvvetleri olarak adlandırılmaktadır.
•  alfabesi üzerinden tanımlanabilecek tüm kelimelerin dili alfabenin kapalılığı
olarak adlandırılmakta ve * olarak gösterilmektedir.
• * sonsuz bir kümedir. *, aynı zamanda "Kleene Star" olarak da
adlandırılmaktadır.
• Diğer bir gösterimle, * = 0 1 2 ....... şeklinde gösterilebilecektir.
• Örneğin, ={0,1} ise
*={, 0, 1, 00, 01, 10, 11, 000, 001, 010, 011, .....} olacaktır. 
SORU
ile 1 birbirine eşit mi?

---

## Sayfa 38

Alfabenin derecesi ve Kleene Star
TEMEL KA VRAMLAR
={0,1} ise,
0={ }
1={0,1}
2={00, 01, 10, 11}
3 = {000, 001, 010, 011, 100, 101, 110, 111 } şeklindeki kümeler alfabenin
kuvvetleri olarak adlandırılmaktadır.
•  alfabesi üzerinden tanımlanabilecek tüm kelimelerin dili alfabenin kapalılığı
olarak adlandırılmakta ve * olarak gösterilmektedir.
• * sonsuz bir kümedir. *, aynı zamanda "Kleene Star" olarak da
adlandırılmaktadır.
• Diğer bir gösterimle, * = 0 1 2 ....... şeklinde gösterilebilecektir.
• Örneğin, ={0,1} ise
*={, 0, 1, 00, 01, 10, 11, 000, 001, 010, 011, .....} olacaktır. 
SORU
ile 1 birbirine eşit mi?
1. Σ is an alphabet; its members 0 and 1 are
symbols
2. 1 is a set of strings; its members are
strings (each one of length 1)

---

## Sayfa 39

Kelimelerin Birleştirilmesi
TEMEL KA VRAMLAR
S bir kelimeler kümesi olmak üzere, S kümesinden seçilen kelimelerin
birleştirilmesi ile oluşan kelimelerin kümesi S* olarak gösterilmektedir.
Örneğin, S={aa, b} ise
S*={, ve aa ile b kelimelerinin faktörlerinden oluşan kelimeler} veya
S*={, b, aa, bb, aab, baa, bbb, .......} olarak tanımlanabilecektir.
Bir kelimenin S* içinde olduğunu göstermek için S kümesindeki semboller
cinsinden faktörlere ayrılması gerekmektedir.
• Örnek-1:
S={a, ab}
S*={, a, aa, ab, aaa, aab, ....}
abaab (ab) (a) (ab) tekil (unique) faktörlere ayırma.

---

## Sayfa 40

Kelimelerin Birleştirilmesi
TEMEL KA VRAMLAR
• Örnek-2:
S={xx, xxx}
S*={, xx, xxx, xxxxx, xxxxxxx, .......}
xxxxxxx (xx) (xx) (xxx) veya (xx) (xxx) (xx) veya (xxx) (xx) (xx)
• Örnek-3:
S={W1,W2,W3}
S+ : Null () kelime dışındaki S* kümesidir.
S+={W1,W2,W3,W1W1,W1W2,W1W3,W2W1,W2W2,W2W3,W3W1,W3W2, W3W3, W1W1W1,
W1W1W2, …}

---

## Sayfa 41

Kelimelerin Birleştirilmesi
TEMEL KA VRAMLAR
soru:
S={a, bb, bab, abaab} ise S* nedir?
abbabaabab kelimesi S* kümesinin elemanı mıdır?
Toplam b’lerin sayısı tek olan herhangi bir kelime S* kümesinde varmı dır?

---

## Sayfa 42

Kaynaklar
• http://erkanulker.bayebilisim.com/dersler/2019_2020/Outomata_The
ory/Outomata_Theory.htm
• https://en.wikipedia.org/wiki/Substring
• http://www.m-hikari.com/ams/ams-2014/ams-125-128-
2014/singhAMS125-128-2014.pdf
• https://www.univ-
orleans.fr/lifo/Members/Mirian.Halfeld/Cours/TLComp/TLComp-
introTL.pdf

---

