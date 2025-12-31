# DERS 2.pdf

*Bu doküman PDF'den otomatik olarak dönüştürülmüştür.*

---

## Sayfa 1

Otomata Teorisi
Derrrsssss--2
DÜZENLİ İFADELER (REGULAR EXPRESSIONS)
Tokat Gaziosmanpaşa Üniversitesi
Tokat Gaziosmanpaşa Üniversitesi
Bilgisayar Mühendisliği Bölümü

---

## Sayfa 2

¾ALFABE(Alphabet) ¾KELİME(Word) ¾DİL(Language)
Kelimelerin üretiminde kullanılan
birimlerin sonlu kümesine alfabe
denir. Alfabenin elemanlar ı
genelde "sembol" veya "harf"
olarak adland ırılmaktadır. Alfabe
genelde 6 sembolü ile
gösterilmektedir
Kelime, 6 alfabesinden seçilen sonlu
sayıdaki sembolün bir araya
gelmesinden oluşmaktadır.
Bir alfabe üzerinden üretilmiş olan  
kelimelerin kümesi dildir.
Dile ait olan kelimelerin nasıl 
üretileceğinin kuralları tanımlanmış ise 
söz konusu dil biçimsel (formal) dil olarak 
adlandırılmaktadır
Düzenli İfadeler

---

## Sayfa 3

¾ALFABE(Alphabet) ¾KELİME(Word) ¾DİL(Language)
Kelimelerin üretiminde kullanılan
birimlerin sonlu kümesine alfabe
denir. Alfabenin elemanlar ı
genelde "sembol" veya "harf"
olarak adland ırılmaktadır. Alfabe
genelde 6 sembolü ile
gösterilmektedir
Kelime, 6 alfabesinden seçilen sonlu
sayıdaki sembolün bir araya
gelmesinden oluşmaktadır.
Bir alfabe üzerinden üretilmiş olan  
kelimelerin kümesi dildir.
Dile ait olan kelimelerin nasıl 
üretileceğinin kuralları tanımlanmış ise 
söz konusu dil biçimsel (formal) dil olarak 
adlandırılmaktadır
Düzenli ifade (regular expression), dil tan ımlayıcı ifadedir. Düzenli ifadeler ile
tanımlanan diller düzenli diller (regular languages) olarak adland ırılmaktadır. Temel
kavramlar bölümünde verilen örneklerde, diller küme biçiminde tan ımlanmaktaydı.
Örneğin, 6={x} olmak üzere, L={ x n , n=1,3,5,7,... } kümesi tek sayıda x sembolünden
oluşan kelimelerin dilini göstermektedir. Bu gösterim her ne kadar do ğru olsa da,
daha biçimsel (formal) bir gösterim de ortaya konmal ıdır. Böylece, daha karma şık
dillerin de standart ve kolay bir biçimde tan ımlanması sağlanmış olacaktır. Düzenli
ifadeler, bu biçimsel gösterimi sağlamaktadır.
Düzenli İfadeler
¾Düzenli İfadeler

---

## Sayfa 4

6={x} olmak üzere, L={ /, x, xx, xxx, xxxx, ..... } kümesi ile tan ımlanan dil, bo ş kelime de dahil
olmak üzere içerisinde herhangi bir say ıda x sembolü olan tüm kelimelerin dilidir. L dilini
tanımlayan düzenli ifade, x* ifadesidir. Diğer deyişle, x* i f a d e s i0 ,1 ,2 ,n ,… ,s o n s u z ak a d a rgiden
sayıda x sembolünden oluşan kelimeleri ifade eder.
Düzenli İfadeler
Örnek -1

---

## Sayfa 5

6={a,b} olmak üzere,
L={a, ab, abb, abbb, abbbb, ..... } kümesi ile tan ımlanan dil, ab* düzenli ifadesi ile
tanımlanabilecektir.
L={/, ab, abab, ababab, ......} biçimindeki bir dil ise, (ab)* düzenli ifadesi ile tanımlanabilecektir.
Düzenli İfadeler
Örnek -2

---

## Sayfa 6

6={a,b} olmak üzere,
L={a, ab, abb, abbb, abbbb, ..... } kümesi ile tan ımlanan dil, ab* düzenli ifadesi ile
tanımlanabilecektir.
L={/, ab, abab, ababab, ......} biçimindeki bir dil ise, (ab)* düzenli ifadesi ile tanımlanabilecektir.
Düzenli İfadeler
Örnek -2
ÖNEMLİ!!!
ab* z(ab)*

---

## Sayfa 7

6={a,b,c} alfabesi üzerinde tanımlı L4={a, c, ab, cb, abb, cbb, abbb, cbbb, .......} dili,
(a+c)b* düzenli ifadesi ile tanımlanabilecektir.
Bu örnekteki (a+c) ifadesi, parantez içerisi ndeki sembollerden birisinin seçilece ği( av e y a c)
anlamına gelmektedir.
Seçilen a veya c sembolünü, n=0,1,2,3,.... olmak üzere n tane b sembolü izleyebilmektedir.
Düzenli İfadeler
Örnek -3

---

## Sayfa 8

6={a,b} olmak üzere, a ve b sembollerinden oluşan üç uzunluktaki tüm kelimeleri içeren dil L ise,
bu dil (a+b)(a+b)(a+b) düzenli ifadesi ile tanımlanabilecektir.
Soru:
L dilinde kaç elman bulunmaktadır?
Düzenli İfadeler
Örnek -4

---

## Sayfa 9

6={a,b} olmak üzere, a ve b sembollerinden oluşan üç uzunluktaki tüm kelimeleri içeren dil L ise,
bu dil (a+b)(a+b)(a+b) düzenli ifadesi ile tanımlanabilecektir.
Soru:
L dilinde kaç elman bulunmaktadır?
Düzenli İfadeler
Örnek -4
L dilinde yalnızca sekiz eleman bulunmaktadır. Bunlar;
aaa,
aab,
aba,
abb,
baa,
bab,
bba,
bbb

---

## Sayfa 10

6={a,b} olmak üzere a*b* düzenli ifadesi ile tan ımlanan dil, bo ş kelime ve e ğer varsa a
sembollerinin b sembollerinden önce geldiği kelimelerin dilidir.
Bu dil, L={ /, a, b, aa, ab, bb, aaa, aab, abb, bbb, aaaa, aaabb, ......} biçiminde de
tanımlanabilecektir.
Düzenli İfadeler
Örnek -5

---

## Sayfa 11

6={x} olmak üzere, tek sayıda x sembolü içeren kelimelerin dili
L=x(xx)* veya L=(xx)*x olarak da tanımlanabilecektir. Bu örnekte, değişme özelliği görülmektedir.
Diğer taraftan, x*xx* düzenli ifadesi, belirtilen dili tan ımlamamaktadır. Bunun nedeni, x*xx*
ifadesi, faktörlere ayrılmış biçimiyle (xx)(x)(x) yani xxxx kelimesinin dilin eleman ı olmasına izin
vermektedir.B ud at e ks a yıda x sembolü içerme kural ına aykırıdır. Bir düzenli ifade, bir dile ait
olmayan hiçbir kelimenin tanımına izin vermemelidir.
Düzenli İfadeler
Örnek -6

---

## Sayfa 12

6={a,b} olmak üzere, a sembolü ile ba şlayan ve b sembolü ile biten tüm kelimelerin dilini
tanımlayın.
Düzenli İfadeler
Örnek -7

---

## Sayfa 13

6={a,b} olmak üzere, a sembolü ile ba şlayan ve b sembolü ile biten tüm kelimelerin dilini
tanımlayın.
Düzenli İfadeler
Örnek -7
Bu dil L =a(a+b)*b düzenli ifadesi ile tanımlanabilecektir.

---

## Sayfa 14

6={a,b} olmak üzere, herhangi bir yerinde en az bir a sembolü bulunan kelimelerin dilini 
tanımlayın.
Düzenli İfadeler
Örnek -8

---

## Sayfa 15

6={a,b} olmak üzere, herhangi bir yerinde en az bir a sembolü bulunan kelimelerin dilini 
tanımlayın.
Bu dil (a+b)*a(a+b)* düzenli ifadesi ile tanımlanabilmektedir. Boş kelime ve yalnızca b 
sembollerinden oluşan kelimeler budilin elemanı değildir.
Düzenli İfadeler
Örnek -8

---

## Sayfa 16

6={a,b} olmak üzere, en az iki a sembolü içeren kelimelerin dilini tanımlayınız.
Düzenli İfadeler
Örnek -9

---

## Sayfa 17

6={a,b} olmak üzere, en az iki a sembolü içeren kelimelerin dilini tanımlayınız.
Bu dil (a+b)*a(a+b)*a(a+b)* düzenli ifadesi ile tanımlanabilmektedir. Diğer taraftan, b*ab*a(a+b)* 
düzenli ifadesi de en az iki a içeren kelimelerin dilini tanımlıyor olarak nitelendirilebilecektir.
Düzenli İfadeler
Örnek -9

---

## Sayfa 18

6={a,b} olmak üzere, yalnızca iki a sembolü içeren kelimelerin dili tanımlayınız.
Düzenli İfadeler
Örnek -10

---

## Sayfa 19

6={a,b} olmak üzere, yalnızca iki a sembolü içeren kelimelerin dili tanımlayınız.
Bu dil b*ab*ab* düzenli ifadesi ile tanımlanabilecektir.
Düzenli İfadeler
Örnek -10

---

## Sayfa 20

• 6={a,b} olmak üzere, en az bir a sembolü ve en az bir b sembolü içeren kelimelerin dili 
tanımlayınız. 
Düzenli İfadeler
Örnek -11

---

## Sayfa 21

• 6={a,b} olmak üzere, en az bir a sembolü ve en az bir b sembolü içeren kelimelerin dili 
tanımlayınız. 
Bu dil aşağıdaki düzenli ifade ile tanımlanabilecektir.
[(a+b)*a(a+b)*b(a+b)*]+[(a+b)*b(a+b)*a(a+b)*]
Düzenli İfadeler
Örnek -11

---

## Sayfa 22

6={a,b} olmak üzere, yaln ızca b sembollerinden olu şan veya bir a sembol ünü izleyen b
sembollerinden oluşan dil, L= b*+ab* düzenli ifadesi ile tanımlanabilecektir.
Diğer bir alternatif nedir?
Düzenli İfadeler
Örnek -12

---

## Sayfa 23

6={a,b} olmak üzere, yaln ızca b sembollerinden olu şan veya bir a sembol ünü izleyen b
sembollerinden oluşan dil, L= b*+ab* düzenli ifadesi ile tanımlanabilecektir.
Diğer bir alternatif nedir?
Düzenli İfadeler
Örnek -12
(/+a)b* şeklinde tanımlanabilir.

---

## Sayfa 24

6={0,1} olmak üzere, çift sayıda uzunluktaki kelimelerin dili nedir?
Düzenli İfadeler
Örnek -13

---

## Sayfa 25

6={0,1} olmak üzere, çift sayıda uzunluktaki kelimelerin dili nedir?
Düzenli İfadeler
Örnek -13
L=(00+01+10+11)* düzenli ifadesi ile çift sayıda uzunluktaki kelimelerin dili tanımlanmaktadır.

---

## Sayfa 26

• 6={0,1} olmak üzere, tek sayıda uzunluktaki kelimelerin dilini tanımlayabilecek düzenli 
ifadeleri yazınız.
Düzenli İfadeler
Örnek -14

---

## Sayfa 27

• 6={0,1} olmak üzere, tek sayıda uzunluktaki kelimelerin dilini tanımlayabilecek düzenli
ifadeleri yazınız.
Örnek ifadeler:
(0+1)(00+01+10+11)*
(00+01+10+11)*(0+1)
0+1+(00+01+10+11)(0+1)(00+01+10+11
Düzenli İfadeler
Örnek -14

---

## Sayfa 28

6={0,1} olmak üzere, L=(a+b)* (aa+bb) (a+b)* düzenli ifadesi ile tanımlanan dili nasıl ifade 
edersiniz? 
Düzenli İfadeler
Örnek -15

---

## Sayfa 29

6={0,1} olmak üzere, L=(a+b)* (aa+bb) (a+b)* düzenli ifadesi ile tanımlanan dili nasıl ifade 
edersiniz? 
Cevap:
Herhangi bir yerinde aa veya bb gibi çift sembol içeren kelimelerin dilidir.
Düzenli İfadeler
Örnek -15

---

## Sayfa 30

6={0,1} olmak üzere, çeşitli biçimlerde bir araya gelmiş 0 ve 1 sembollerini iki tane 1 sembolü 
ve bunu da eğer varsa 0 sembolünü   mutlaka 1 sembol(lerinin) izlediği kelimelerin dili için 
düzenli ifade yazınız.
Düzenli İfadeler
Örnek -16

---

## Sayfa 31

6={0,1} olmak üzere, çeşitli biçimlerde bir araya gelmiş 0 ve 1 sembollerini iki tane 1 sembolü ve 
bunu da eğer varsa 0 sembolünü   mutlaka 1 sembol(lerinin) izlediği kelimelerin dili için düzenli 
ifade yazınız.
Cevap:
(0+1)*11(1+01)* 
NOT: Bu tür örüntüler, görüntü işleme (imageprocessing) veya örüntü tanıma (pattern 
recognation) konularında görülebilmektedir. 
Düzenli İfadeler
Örnek -16

---

## Sayfa 32

6={0,1} olmak üzere, EVEN-EVEN= { /, aa, bb, aabb, abab, abba, baab, bbaa, aaaabb, ..... } (Çift 
sayıda a ve b içeren kelimelerin dili). Bu dile ilişkin bir düzenli ifade yazınız.
Düzenli İfadeler
Örnek -17

---

## Sayfa 33

6={0,1} olmak üzere, EVEN-EVEN= { /, aa, bb, aabb, abab, abba, baab, bbaa, aaaabb, ..... } (Çift 
sayıda a ve b içeren kelimelerin dili). Bu dile ilişkin bir düzenli ifade yazınız.
Düzenli İfadeler
Örnek -17
• [aa + bb + (ab+ba)(aa+bb)*(ab+ba)]*
Factor-1 Factor-2
Factor-3

---

## Sayfa 34

Yanyana iki a (double a) içermeyen kelimelerin diline ilişkin bir düzenli ifade yazınız. 
Düzenli İfadeler
Örnek -18

---

## Sayfa 35

Yanyana iki a (double a) içermeyen kelimelerin diline ilişkin bir düzenli ifade yazınız. 
Düzenli İfadeler
Örnek -18
• b*(abb*)*(/+a)

---

## Sayfa 36

6={b,d,k,t}olmak üzere 
L=k[(bd)+(bbdd)+(bbbddd)]*t  düzenli ifadesi veriliyor. Bu ifadeden üretilebilecek en kısa 
uzunluktaki kelimelerden 5 tanesini yazınız.
Düzenli İfadeler
Örnek -19

---

## Sayfa 37

6={b,d,k,t}olmak üzere 
L=k[(bd)+(bbdd)+(bbbddd)]*t  düzenli ifadesi veriliyor. Bu ifadeden üretilebilecek en kısa 
uzunluktaki kelimelerden 5 tanesini yazınız.
Düzenli İfadeler
Örnek -19
• kt
• kbdt
• kbdbdt
• kbbddt

---

