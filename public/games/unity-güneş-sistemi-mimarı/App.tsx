import React, { useState } from 'react';
import { Viewer3D } from './components/Viewer3D';
import { PlanetData } from './types';
import { generateSolarSystem } from './services/geminiService';
import { generateUnityScript } from './utils/unityGenerator';
import { 
  PlusIcon, 
  TrashIcon, 
  CodeBracketIcon, 
  SparklesIcon, 
  XMarkIcon,
  CubeIcon
} from '@heroicons/react/24/outline';

const INITIAL_PLANETS: PlanetData[] = [
  { id: 'p1', name: 'Merkür', color: '#A5A5A5', radius: 0.8, distance: 7, speed: 2.0, description: "Güneşe en yakın, sıcak ve kraterli." },
  { id: 'p2', name: 'Venüs', color: '#E3BB76', radius: 1.4, distance: 10, speed: 1.6, description: "Yoğun atmosferi olan sıcak gezegen." },
  { id: 'p3', name: 'Dünya', color: '#22A6B3', radius: 1.5, distance: 14, speed: 1.3, description: "Yaşam barındıran mavi gezegen." },
  { id: 'p4', name: 'Mars', color: '#EB4C42', radius: 1.1, distance: 18, speed: 1.0, description: "Kızıl gezegen." },
  { id: 'p5', name: 'Jüpiter', color: '#D39C7E', radius: 3.5, distance: 26, speed: 0.6, description: "Sistemin en büyük gaz devi." },
  { id: 'p6', name: 'Satürn', color: '#F4D03F', radius: 3.0, distance: 35, speed: 0.45, description: "Halkalarıyla ünlü gaz devi." },
  { id: 'p7', name: 'Uranüs', color: '#7DE5F6', radius: 2.0, distance: 44, speed: 0.3, description: "Buz devi." },
  { id: 'p8', name: 'Neptün', color: '#3B64E6', radius: 2.0, distance: 52, speed: 0.2, description: "Rüzgarlı mavi buz devi." },
];

export default function App() {
  const [planets, setPlanets] = useState<PlanetData[]>(INITIAL_PLANETS);
  const [systemName, setSystemName] = useState<string>("Güneş Sistemi");
  const [lore, setLore] = useState<string>("Samanyolu galaksisinde bulunan, yaşam barındıran bildiğimiz tek yıldız sistemi.");
  const [isGenerating, setIsGenerating] = useState(false);
  const [showCode, setShowCode] = useState(false);

  const handleUpdatePlanet = (id: string, field: keyof PlanetData, value: string | number) => {
    setPlanets(prev => prev.map(p => 
      p.id === id ? { ...p, [field]: value } : p
    ));
  };

  const handleAddPlanet = () => {
    const newPlanet: PlanetData = {
      id: Math.random().toString(36).substr(2, 9),
      name: `Gezegen ${planets.length + 1}`,
      color: '#808080',
      radius: 1,
      distance: (planets.length > 0 ? Math.max(...planets.map(p => p.distance)) : 10) + 6,
      speed: 0.5,
    };
    setPlanets([...planets, newPlanet]);
  };

  const handleRemovePlanet = (id: string) => {
    setPlanets(prev => prev.filter(p => p.id !== id));
  };

  const handleGenerateAI = async () => {
    setIsGenerating(true);
    try {
      const result = await generateSolarSystem();
      setSystemName(result.systemName);
      setLore(result.lore);
      setPlanets(result.planets);
    } catch (e) {
      alert("Güneş sistemi oluşturulamadı. Lütfen konsolu kontrol edin.");
    } finally {
      setIsGenerating(false);
    }
  };

  const generatedCode = generateUnityScript(planets, systemName);

  return (
    <div className="flex h-screen w-full bg-space-900 overflow-hidden font-sans">
      
      {/* LEFT SIDEBAR - CONTROLS */}
      <div className="w-96 flex flex-col border-r border-space-700 bg-space-800/50 backdrop-blur-md z-10 shadow-2xl">
        {/* Header */}
        <div className="p-6 border-b border-space-700 bg-space-900">
          <div className="flex items-center gap-2 mb-2">
            <CubeIcon className="w-6 h-6 text-blue-400" />
            <h1 className="text-xl font-bold bg-gradient-to-r from-blue-400 to-purple-400 bg-clip-text text-transparent">
              Unity Güneş Sistemi Mimarı
            </h1>
          </div>
          <p className="text-xs text-gray-400">Sistem tasarla, C# kodunu dışa aktar.</p>
        </div>

        {/* Global Actions */}
        <div className="p-4 grid grid-cols-2 gap-3 border-b border-space-700">
          <button 
            onClick={handleGenerateAI}
            disabled={isGenerating}
            className="flex items-center justify-center gap-2 bg-gradient-to-r from-purple-600 to-indigo-600 hover:from-purple-500 hover:to-indigo-500 text-white py-2 px-3 rounded-md text-sm font-medium transition-all disabled:opacity-50"
          >
            {isGenerating ? <div className="animate-spin h-4 w-4 border-2 border-white border-t-transparent rounded-full"/> : <SparklesIcon className="w-4 h-4" />}
            AI ile Üret
          </button>
          
          <button 
            onClick={() => setShowCode(true)}
            className="flex items-center justify-center gap-2 bg-space-700 hover:bg-space-600 text-white py-2 px-3 rounded-md text-sm font-medium transition-all border border-space-600"
          >
            <CodeBracketIcon className="w-4 h-4" />
            C# Dışa Aktar
          </button>
        </div>

        {/* System Info */}
        <div className="p-4 bg-space-800/30 border-b border-space-700">
           <label className="block text-xs uppercase tracking-wider text-gray-500 mb-1">Sistem Adı</label>
           <input 
             type="text" 
             value={systemName} 
             onChange={(e) => setSystemName(e.target.value)}
             className="w-full bg-space-900 border border-space-600 rounded px-2 py-1 text-sm text-white focus:outline-none focus:border-blue-500"
           />
           <div className="mt-2 text-xs text-gray-400 italic line-clamp-2">
             {lore}
           </div>
        </div>

        {/* Planet List */}
        <div className="flex-1 overflow-y-auto p-4 space-y-4">
          <div className="flex justify-between items-center mb-2">
            <h2 className="text-sm font-semibold text-gray-300 uppercase tracking-wide">Gezegenler ({planets.length})</h2>
            <button 
              onClick={handleAddPlanet}
              className="text-xs bg-blue-600/20 hover:bg-blue-600/40 text-blue-400 p-1 rounded transition-colors"
            >
              <PlusIcon className="w-4 h-4" />
            </button>
          </div>

          {planets.map((planet) => (
            <div key={planet.id} className="bg-space-700/30 border border-space-600 rounded-lg p-3 hover:border-space-500 transition-colors group">
              <div className="flex justify-between items-start mb-3">
                <input 
                  value={planet.name}
                  onChange={(e) => handleUpdatePlanet(planet.id, 'name', e.target.value)}
                  className="bg-transparent font-medium text-sm text-white focus:outline-none w-2/3 border-b border-transparent focus:border-blue-500/50"
                />
                <button 
                  onClick={() => handleRemovePlanet(planet.id)}
                  className="text-gray-500 hover:text-red-400 opacity-0 group-hover:opacity-100 transition-opacity"
                >
                  <TrashIcon className="w-4 h-4" />
                </button>
              </div>

              <div className="space-y-3">
                {/* Visual Settings Row */}
                <div className="flex items-center gap-3">
                  <div className="relative">
                    <input 
                      type="color" 
                      value={planet.color}
                      onChange={(e) => handleUpdatePlanet(planet.id, 'color', e.target.value)}
                      className="w-8 h-8 rounded cursor-pointer overflow-hidden opacity-0 absolute inset-0 z-10"
                    />
                    <div className="w-8 h-8 rounded border border-gray-600" style={{ backgroundColor: planet.color }}></div>
                  </div>
                  <div className="flex-1">
                     <label className="text-[10px] text-gray-500 block">Yarıçap</label>
                     <input 
                       type="range" min="0.5" max="5" step="0.1"
                       value={planet.radius}
                       onChange={(e) => handleUpdatePlanet(planet.id, 'radius', parseFloat(e.target.value))}
                       className="w-full h-1 bg-space-600 rounded-lg appearance-none cursor-pointer"
                     />
                  </div>
                </div>

                {/* Orbit Settings */}
                <div className="grid grid-cols-2 gap-2">
                  <div>
                    <label className="text-[10px] text-gray-500 flex justify-between">
                      <span>Mesafe</span>
                      <span>{planet.distance}</span>
                    </label>
                    <input 
                       type="range" min="5" max="80" step="1"
                       value={planet.distance}
                       onChange={(e) => handleUpdatePlanet(planet.id, 'distance', parseFloat(e.target.value))}
                       className="w-full h-1 bg-space-600 rounded-lg appearance-none cursor-pointer"
                     />
                  </div>
                  <div>
                    <label className="text-[10px] text-gray-500 flex justify-between">
                      <span>Hız</span>
                      <span>{planet.speed}</span>
                    </label>
                    <input 
                       type="range" min="0.1" max="5" step="0.1"
                       value={planet.speed}
                       onChange={(e) => handleUpdatePlanet(planet.id, 'speed', parseFloat(e.target.value))}
                       className="w-full h-1 bg-space-600 rounded-lg appearance-none cursor-pointer"
                     />
                  </div>
                </div>
              </div>
            </div>
          ))}
        </div>
      </div>

      {/* RIGHT - 3D CANVAS */}
      <div className="flex-1 h-full relative">
        <Viewer3D planets={planets} />
        
        {/* Helper Overlay */}
        <div className="absolute top-4 right-4 text-right pointer-events-none">
          <h2 className="text-2xl font-light text-white opacity-80">{systemName}</h2>
          <p className="text-sm text-blue-300 opacity-60">Unity Asset Önizleme</p>
        </div>
      </div>

      {/* MODAL - CODE EXPORT */}
      {showCode && (
        <div className="fixed inset-0 bg-black/80 backdrop-blur-sm z-50 flex items-center justify-center p-8">
          <div className="bg-space-800 border border-space-600 rounded-xl w-full max-w-4xl h-[80vh] flex flex-col shadow-2xl">
             <div className="p-4 border-b border-space-700 flex justify-between items-center bg-space-900 rounded-t-xl">
               <div className="flex items-center gap-3">
                 <div className="p-2 bg-blue-900/30 rounded-lg">
                   <CodeBracketIcon className="w-5 h-5 text-blue-400" />
                 </div>
                 <div>
                    <h3 className="text-lg font-bold text-white">C# Script Dışa Aktarma</h3>
                    <p className="text-xs text-gray-400">Unity'de <span className="text-yellow-400 font-mono">{systemName.replace(/[^a-zA-Z0-9]/g, "")}Generator.cs</span> adında bir script oluşturun ve bu kodu yapıştırın.</p>
                 </div>
               </div>
               <button onClick={() => setShowCode(false)} className="text-gray-400 hover:text-white p-2">
                 <XMarkIcon className="w-6 h-6" />
               </button>
             </div>
             
             <div className="flex-1 overflow-hidden relative">
               <textarea 
                 className="w-full h-full bg-[#0d1117] text-gray-300 font-mono text-sm p-4 resize-none focus:outline-none"
                 value={generatedCode}
                 readOnly
               />
             </div>

             <div className="p-4 border-t border-space-700 bg-space-900 rounded-b-xl flex justify-end">
               <button 
                 onClick={() => {
                    navigator.clipboard.writeText(generatedCode);
                    alert("Kod panoya kopyalandı!");
                 }}
                 className="bg-blue-600 hover:bg-blue-500 text-white px-6 py-2 rounded-md font-medium transition-colors"
               >
                 Panoya Kopyala
               </button>
             </div>
          </div>
        </div>
      )}
    </div>
  );
}