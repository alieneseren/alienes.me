import React, { useRef } from 'react';
import { Canvas, useFrame } from '@react-three/fiber';
import { OrbitControls, Stars, Html } from '@react-three/drei';
import * as THREE from 'three';
import { PlanetData } from '../types';

// Fix for missing R3F types in JSX
// Extending React's JSX namespace is required for newer React versions
declare module 'react' {
  namespace JSX {
    interface IntrinsicElements {
      group: any;
      mesh: any;
      ringGeometry: any;
      meshBasicMaterial: any;
      sphereGeometry: any;
      meshStandardMaterial: any;
      ambientLight: any;
      pointLight: any;
    }
  }
}

// Fallback for global JSX namespace
declare global {
  namespace JSX {
    interface IntrinsicElements {
      group: any;
      mesh: any;
      ringGeometry: any;
      meshBasicMaterial: any;
      sphereGeometry: any;
      meshStandardMaterial: any;
      ambientLight: any;
      pointLight: any;
    }
  }
}

interface PlanetMeshProps {
  planet: PlanetData;
}

const PlanetMesh: React.FC<PlanetMeshProps> = ({ planet }) => {
  const meshRef = useRef<THREE.Mesh>(null);
  const orbitRef = useRef<THREE.Group>(null);

  useFrame(({ clock }) => {
    if (orbitRef.current) {
      orbitRef.current.rotation.y = clock.getElapsedTime() * (planet.speed * 0.2);
    }
    if (meshRef.current) {
      meshRef.current.rotation.y += 0.01;
    }
  });

  return (
    <group rotation={[0, 0, 0]}>
      {/* Orbit Line */}
      <mesh rotation={[-Math.PI / 2, 0, 0]}>
        <ringGeometry args={[planet.distance - 0.1, planet.distance + 0.1, 64]} />
        <meshBasicMaterial color="#ffffff" opacity={0.1} transparent side={THREE.DoubleSide} />
      </mesh>

      {/* Rotating Group for Orbit Position */}
      <group ref={orbitRef}>
        <mesh 
          ref={meshRef} 
          position={[planet.distance, 0, 0]}
          onClick={(e) => {
            e.stopPropagation();
            console.log("Clicked", planet.name);
          }}
        >
          <sphereGeometry args={[planet.radius, 32, 32]} />
          <meshStandardMaterial color={planet.color} roughness={0.7} metalness={0.1} />
          <Html distanceFactor={15}>
            <div className="bg-black/70 text-white text-xs px-2 py-1 rounded select-none whitespace-nowrap backdrop-blur-sm pointer-events-none">
              {planet.name}
            </div>
          </Html>
        </mesh>
      </group>
    </group>
  );
};

interface Viewer3DProps {
  planets: PlanetData[];
}

export const Viewer3D: React.FC<Viewer3DProps> = ({ planets }) => {
  return (
    <div className="w-full h-full bg-black relative">
      <Canvas camera={{ position: [0, 20, 35], fov: 45 }}>
        <ambientLight intensity={0.2} />
        <pointLight position={[0, 0, 0]} intensity={2} color="#ffaa00" decay={0} distance={100} />
        
        <Stars radius={100} depth={50} count={5000} factor={4} saturation={0} fade speed={1} />
        
        {/* Sun */}
        <mesh position={[0, 0, 0]}>
          <sphereGeometry args={[4, 32, 32]} />
          <meshBasicMaterial color="#FDB813" />
          <Html position={[0, 4.5, 0]}>
             <div className="text-yellow-400 font-bold text-sm tracking-widest text-center">GÜNEŞ</div>
          </Html>
        </mesh>
        
        {/* Sun Glow/Atmosphere (Simplified) */}
        <mesh position={[0, 0, 0]}>
          <sphereGeometry args={[4.5, 32, 32]} />
          <meshBasicMaterial color="#FDB813" transparent opacity={0.2} />
        </mesh>

        {planets.map((planet) => (
          <PlanetMesh key={planet.id} planet={planet} />
        ))}

        <OrbitControls minDistance={10} maxDistance={150} />
      </Canvas>
      
      <div className="absolute bottom-4 left-4 text-white/50 text-xs pointer-events-none">
        <p>Sol Tık: Döndür • Sağ Tık: Kaydır • Tekerlek: Yakınlaştır</p>
      </div>
    </div>
  );
};