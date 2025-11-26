# DERS 3.pdf

*Bu doküman PDF'den otomatik olarak dönüştürülmüştür.*

---

## Sayfa 1

Otomata Teorisi
SONLU 
OTOMATA 
(FINITE 
AUTOMATA)
Tokat Gaziosmanpaşa Üniversitesi
Bilgisayar Mühendisliği Bölümü

---

## Sayfa 2

Tanım
• Sonlu otomata (finite automata), durumları (states) içeren bir küme ve dışsal girdilere göre bu durumlar 
arasında gerçekleşen geçişlerden oluşmaktadır.
• Belli bir girdiye ilişkin olarak, belli bir durumdan sadece tek bir çıkış varsa söz konusu sonlu otomata 
deterministik olarak adlandırılır. Bu kurala uymayan otomatalar, deterministik değildir (non-deterministic).
SONLU OTOMATA

---

## Sayfa 3

Biçimsel Tanım
• Bir deterministik sonlu otomata, M=(Q, , δ, S, F) biçiminde belirtilen bir beşli
ile ifade edilmektedir:
• Q: Durumlara ilişkin sembollerden oluşan alfabedir.
• : Girdi sembollerinin alfabesidir.
• f: Q x Q olmak üzere geçiş fonksiyonudur.
• S Q olmak üzere başlangıç durumudur (start state).
• F Q olmak üzere sonuç durumları (final states) kümesidir.
SONLU OTOMATA

---

## Sayfa 4

Biçimsel Tanım
• M=(Q, , δ, s, F)
• Q: {𝐪𝟎, 𝐪𝟏, 𝐪𝟐}
• : {a,b}
• δ: geçişler
• S:𝐪𝟎
• F:𝐪𝟐
SONLU OTOMATA
Geçiş Tablosu
• Sonlu otomatalar, 2 şekilde gösterilebilmektedir:
• Geçiş Diyagramı (Transition Diagram)
• Geçiş Tablosu (Transition Table)
Geçiş Diyagramı


---

## Sayfa 5

Biçimsel Tanım
• M=(Q, , δ, s, F)
• Q: {𝐪𝟎, 𝐪𝟏, 𝐪𝟐}
• : {a,b}
• δ: geçişler
• S:𝐪𝟎
• F:𝐪𝟐
SONLU OTOMATA
Geçiş Tablosu
• Sonlu otomatalar, 2 şekilde gösterilebilmektedir:
• Geçiş Diyagramı (Transition Diagram)
• Geçiş Tablosu (Transition Table)
Geçiş Diyagramı


---

## Sayfa 6

Biçimsel Tanım
• M=(Q, , δ, s, F)
• Q: {𝐪𝟎, 𝐪𝟏, 𝐪𝟐}
• : {a,b}
• δ: geçişler
• S:𝐪𝟎
• F:𝐪𝟐
SONLU OTOMATA
Geçiş Tablosu
• Sonlu otomatalar, 2 şekilde gösterilebilmektedir:
• Geçiş Diyagramı (Transition Diagram)
• Geçiş Tablosu (Transition Table)
Geçiş Diyagramı


---

## Sayfa 7

={a,b} olmak üzere, her zaman a ile başlayan kelimelerin oluşturduğu düzenli ifadeyi ve sonlu
otomatı tasarlayınız.
Düzenli İfadeler
Örnek -1
L=a(a+b)*Cevap -1


---

## Sayfa 8

={a,b} olmak üzere, her zaman a ile başlayan kelimelerin oluşturduğu düzenli ifadeyi ve sonlu
otomatı tasarlayınız.
Düzenli İfadeler
Örnek -1
L=a(a+b)*Cevap -1


---

## Sayfa 9

={a,b} olmak üzere, her zaman a ile başlayan kelimelerin oluşturduğu düzenli ifadeyi ve sonlu
otomatı tasarlayınız.
Düzenli İfadeler
Örnek -1
L=a(a+b)*Cevap -1


---

## Sayfa 10

={a,b} olmak üzere, her zaman a ile biten kelimelerin oluşturduğu düzenli ifadeyi ve sonlu
otomatı tasarlayınız.
Düzenli İfadeler
Örnek -2
L=(a+b)*aCevap -2


---

## Sayfa 11

={a,b} olmak üzere, her zaman a ile biten kelimelerin oluşturduğu düzenli ifadeyi ve sonlu
otomatı tasarlayınız.
Düzenli İfadeler
Örnek -2
L=(a+b)*aCevap -2


---

## Sayfa 12

={a,b} olmak üzere, her zaman a ile biten kelimelerin oluşturduğu düzenli ifadeyi ve sonlu
otomatı tasarlayınız.
Düzenli İfadeler
Örnek -2
L=(a+b)*aCevap -2


---

## Sayfa 13

={1,0} olmak üzere, içeresinde her zaman «10» alt string i bulunan kelimelerin oluşturduğu
düzenli ifadeyi ve sonlu otomatı tasarlayınız.
Düzenli İfadeler
Örnek -3
L=(1+0)*10(1+0)*Cevap -3


---

## Sayfa 14

={1,0} olmak üzere, içeresinde her zaman «10» alt string i bulunan kelimelerin oluşturduğu
düzenli ifadeyi ve sonlu otomatı tasarlayınız.
Düzenli İfadeler
Örnek -3
L=(1+0)*10(1+0)*Cevap -3


---

## Sayfa 15

={1,0} olmak üzere, içeresinde her zaman «10» alt string i bulunan kelimelerin oluşturduğu
düzenli ifadeyi ve sonlu otomatı tasarlayınız.
Düzenli İfadeler
Örnek -3
L=(1+0)*10(1+0)*Cevap -3


---

## Sayfa 16

={a,b} olmak üzere, her zaman «bb» ile başlayan kelimelerin oluşturduğu düzenli ifadeyi ve
sonlu otomatı tasarlayınız.
Düzenli İfadeler
Örnek -4
L= bb ( a + b )*Cevap -4


---

## Sayfa 17

={a,b} olmak üzere, her zaman «bb» ile başlayan kelimelerin oluşturduğu düzenli ifadeyi ve
sonlu otomatı tasarlayınız.
Düzenli İfadeler
Örnek -4
L= bb ( a + b )*Cevap -4


---

## Sayfa 18

={a,b} olmak üzere, her zaman «bb» ile başlayan kelimelerin oluşturduğu düzenli ifadeyi ve
sonlu otomatı tasarlayınız.
Düzenli İfadeler
Örnek -4
L= bb ( a + b )*Cevap -4


---

## Sayfa 19

={1,0} olmak üzere, içeresinde her zaman «10» alt string i bulunan kelimelerin oluşturduğu
düzenli ifadeyi ve sonlu otomatı tasarlayınız.
Düzenli İfadeler
Örnek -5
L=(1+0)*10(1+0)*Cevap -5


---

## Sayfa 20

={1,0} olmak üzere, içeresinde her zaman «10» alt string i bulunan kelimelerin oluşturduğu
düzenli ifadeyi ve sonlu otomatı tasarlayınız.
Düzenli İfadeler
Örnek -5
L=(1+0)*10(1+0)*Cevap -5


---

## Sayfa 21

={1,0} olmak üzere, içeresinde her zaman «10» alt string i bulunan kelimelerin oluşturduğu
düzenli ifadeyi ve sonlu otomatı tasarlayınız.
Düzenli İfadeler
Örnek -5
L=(1+0)*10(1+0)*Cevap -5


---

