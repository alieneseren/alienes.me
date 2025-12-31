import { PlanetData } from "../types";

export const generateUnityScript = (planets: PlanetData[], systemName: string) => {
  const safeName = systemName.replace(/[^a-zA-Z0-9]/g, "");
  
  const planetInstantiationCode = planets.map(p => {
    // Convert hex color to Unity RGB (0-1 range)
    const r = parseInt(p.color.slice(1, 3), 16) / 255;
    const g = parseInt(p.color.slice(3, 5), 16) / 255;
    const b = parseInt(p.color.slice(5, 7), 16) / 255;

    return `
        // ${p.name} oluşturuluyor
        GameObject planet_${p.id} = GameObject.CreatePrimitive(PrimitiveType.Sphere);
        planet_${p.id}.name = "${p.name}";
        planet_${p.id}.transform.parent = this.transform;
        planet_${p.id}.transform.localScale = Vector3.one * ${p.radius}f;
        
        // Yörünge Scripti Ekle (Inline component)
        OrbitData orbit_${p.id} = planet_${p.id}.AddComponent<OrbitData>();
        orbit_${p.id}.distance = ${p.distance}f;
        orbit_${p.id}.speed = ${p.speed}f;
        orbit_${p.id}.angle = Random.Range(0f, 360f);
        
        // Renk Ayarla
        Renderer rend_${p.id} = planet_${p.id}.GetComponent<Renderer>();
        if(rend_${p.id} != null) {
            rend_${p.id}.material = new Material(Shader.Find("Standard"));
            rend_${p.id}.material.color = new Color(${r.toFixed(3)}f, ${g.toFixed(3)}f, ${b.toFixed(3)}f);
        }
    `;
  }).join("\n");

  return `using UnityEngine;

// BU SCRIPTİ "${safeName}Generator.cs" OLARAK KAYDEDİN
// SAHNENİZDEKİ BOŞ BİR GAME OBJECT'E EKLEYİN

public class ${safeName}Generator : MonoBehaviour
{
    private void Start()
    {
        GenerateSolarSystem();
    }

    private void GenerateSolarSystem()
    {
        // Güneş Oluştur
        GameObject sun = GameObject.CreatePrimitive(PrimitiveType.Sphere);
        sun.name = "Sun";
        sun.transform.parent = this.transform;
        sun.transform.position = Vector3.zero;
        sun.transform.localScale = Vector3.one * 4f;
        
        // Güneş Materyali (Emisyon/Işıma)
        Renderer sunRend = sun.GetComponent<Renderer>();
        if(sunRend != null) {
             Material sunMat = new Material(Shader.Find("Standard"));
             sunMat.SetColor("_EmissionColor", new Color(1f, 0.8f, 0.2f) * 2f);
             sunMat.EnableKeyword("_EMISSION");
             sunMat.color = new Color(1f, 0.8f, 0.2f);
             sunRend.material = sunMat;
        }

        ${planetInstantiationCode}
    }
}

// Çalışma zamanı yörünge hareketi için yardımcı sınıf
public class OrbitData : MonoBehaviour
{
    public float distance;
    public float speed;
    public float angle;

    void Update()
    {
        if (distance > 0)
        {
            angle += speed * Time.deltaTime * 10f; // Görünürlük için hızı ölçekle
            float x = Mathf.Cos(angle * Mathf.Deg2Rad) * distance;
            float z = Mathf.Sin(angle * Mathf.Deg2Rad) * distance;
            transform.localPosition = new Vector3(x, 0, z);
        }
    }
}`;
};