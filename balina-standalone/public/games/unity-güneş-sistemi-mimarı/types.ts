export interface PlanetData {
  id: string;
  name: string;
  color: string;
  radius: number; // Size relative to sun
  distance: number; // Distance from center
  speed: number; // Orbit speed
  description?: string;
}

export interface GenerationResponse {
  planets: PlanetData[];
  systemName: string;
  lore: string;
}