import { GoogleGenAI, Type } from "@google/genai";
import { PlanetData, GenerationResponse } from "../types";

// Helper to generate a unique ID
const generateId = () => Math.random().toString(36).substr(2, 9);

export const generateSolarSystem = async (prompt?: string): Promise<GenerationResponse> => {
  const apiKey = process.env.API_KEY;
  if (!apiKey) {
    throw new Error("API Key not found");
  }

  const ai = new GoogleGenAI({ apiKey });

  // Define the schema for structured output
  const responseSchema = {
    type: Type.OBJECT,
    properties: {
      systemName: { type: Type.STRING, description: "Yıldız sistemi için yaratıcı bir bilim kurgu ismi" },
      lore: { type: Type.STRING, description: "Bu sistemin kısa bir arka plan hikayesi veya açıklaması (Türkçe)" },
      planets: {
        type: Type.ARRAY,
        items: {
          type: Type.OBJECT,
          properties: {
            name: { type: Type.STRING, description: "Gezegen ismi" },
            color: { type: Type.STRING, description: "Hex renk kodu, örn. #FF5733" },
            radius: { type: Type.NUMBER, description: "0.5 ile 3.0 arasında" },
            distance: { type: Type.NUMBER, description: "6 ile 40 arasında, her gezegen için farklı" },
            speed: { type: Type.NUMBER, description: "0.1 ile 2.0 arasında" },
            description: { type: Type.STRING, description: "Gezegenin kısa Türkçe açıklaması" }
          },
          required: ["name", "color", "radius", "distance", "speed"]
        }
      }
    },
    required: ["systemName", "lore", "planets"]
  };

  const userPrompt = prompt || "4 ile 8 gezegenden oluşan dengeli bir güneş sistemi oluştur. Bazıları kayalık, bazıları gaz devi olsun.";

  try {
    const response = await ai.models.generateContent({
      model: "gemini-2.5-flash",
      contents: userPrompt,
      config: {
        responseMimeType: "application/json",
        responseSchema: responseSchema,
        systemInstruction: "Sen Unity oyun motoru için güneş sistemi verileri üreten yaratıcı bir bilim kurgu evren mimarısın. Tüm isimleri, açıklamaları ve hikayeleri Türkçe olarak yanıtla."
      }
    });

    const text = response.text;
    if (!text) throw new Error("No response from AI");

    const data = JSON.parse(text);
    
    // Add IDs locally since the AI doesn't need to generate UUIDs
    const planetsWithIds = data.planets.map((p: any) => ({
      ...p,
      id: generateId()
    }));

    return {
      systemName: data.systemName,
      lore: data.lore,
      planets: planetsWithIds
    };

  } catch (error) {
    console.error("Gemini Generation Error:", error);
    throw error;
  }
};