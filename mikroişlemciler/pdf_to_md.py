#!/usr/bin/env python3
"""PDF dosyasını Markdown formatına dönüştürür."""

from pypdf import PdfReader

def pdf_to_markdown(pdf_path, md_path):
    """PDF dosyasını okuyup markdown formatında kaydeder."""
    reader = PdfReader(pdf_path)
    
    with open(md_path, 'w', encoding='utf-8') as md_file:
        md_file.write(f"# Mikroişlemciler Sunu 2025\n\n")
        md_file.write(f"*Bu doküman PDF'den otomatik olarak dönüştürülmüştür.*\n\n")
        md_file.write(f"---\n\n")
        
        for i, page in enumerate(reader.pages, 1):
            text = page.extract_text()
            md_file.write(f"## Sayfa {i}\n\n")
            md_file.write(text)
            md_file.write("\n\n---\n\n")
    
    print(f"✓ PDF başarıyla markdown'a dönüştürüldü: {md_path}")
    print(f"✓ Toplam {len(reader.pages)} sayfa işlendi.")

if __name__ == "__main__":
    pdf_path = "Mikroişlemciler Sunu 2025.pdf"
    md_path = "Mikroişlemciler_Sunu_2025.md"
    pdf_to_markdown(pdf_path, md_path)
