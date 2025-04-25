import { useEffect, useRef, useState } from 'react';
import { Loader } from 'lucide-react';

interface CarViewer3DProps {
  modelUrl: string;
  fallbackImageUrl: string;
}

const CarViewer3D = ({ modelUrl, fallbackImageUrl }: CarViewer3DProps) => {
  const containerRef = useRef<HTMLDivElement>(null);
  const [isLoading, setIsLoading] = useState(true);
  const [isError, setIsError] = useState(false);

  useEffect(() => {
    // В реальном приложении здесь был бы код для загрузки и отображения 3D модели
    // Например, с использованием Three.js, model-viewer или другой библиотеки для 3D
    
    // Имитация загрузки для демонстрации
    const timer = setTimeout(() => {
      // В реальном приложении, здесь была бы проверка успешности загрузки модели
      if (Math.random() > 0.8) {
        setIsError(true);
      } else {
        setIsLoading(false);
      }
    }, 2000);

    return () => clearTimeout(timer);
  }, [modelUrl]);

  if (isError) {
    return (
      <div className="model-viewer-container flex items-center justify-center">
        <div className="text-center p-6">
          <img 
            src={fallbackImageUrl} 
            alt="Car Preview" 
            className="max-w-full max-h-[400px] mx-auto rounded-lg mb-4"
          />
          <p className="text-muted-foreground">Не удалось загрузить 3D модель</p>
        </div>
      </div>
    );
  }

  return (
    <div ref={containerRef} className="model-viewer-container relative min-h-[400px]">
      {isLoading ? (
        <div className="absolute inset-0 flex items-center justify-center bg-black/5">
          <div className="text-center">
            <Loader className="h-8 w-8 animate-spin mx-auto mb-2" />
            <p className="text-sm text-muted-foreground">Загрузка 3D модели...</p>
          </div>
        </div>
      ) : (
        <div className="absolute inset-0 flex items-center justify-center bg-black/5">
          {/* В реальном приложении здесь был бы контейнер для 3D модели */}
          <div className="text-center p-4">
            <img 
              src={fallbackImageUrl} 
              alt="Car 3D Preview" 
              className="max-w-full max-h-[400px] mx-auto rounded-lg opacity-70"
            />
            <div className="absolute inset-0 flex items-center justify-center">
              <p className="bg-black/50 text-white px-4 py-2 rounded">
                Здесь будет 3D модель автомобиля
              </p>
            </div>
          </div>
        </div>
      )}
    </div>
  );
};

export default CarViewer3D;
