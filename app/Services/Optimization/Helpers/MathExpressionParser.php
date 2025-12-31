<?php

namespace App\Services\Optimization\Helpers;

/**
 * Matematiksel ifade parser
 * Kullanıcı tarafından girilen string ifadeleri güvenli bir şekilde fonksiyona çevirir
 */
class MathExpressionParser
{
    /**
     * İzin verilen matematiksel fonksiyonlar
     */
    private static array $allowedFunctions = [
        'sin', 'cos', 'tan', 'asin', 'acos', 'atan',
        'sinh', 'cosh', 'tanh',
        'sqrt', 'abs', 'exp', 'log', 'log10',
        'pow', 'floor', 'ceil', 'round',
        'min', 'max', 'pi'
    ];

    /**
     * İzin verilen operatörler
     */
    private static array $allowedOperators = ['+', '-', '*', '/', '^', '%', '(', ')', '.', ',', ' '];

    /**
     * İfadeyi doğrula
     */
    public static function validate(string $expression): array
    {
        $errors = [];
        
        // Boş kontrol
        if (empty(trim($expression))) {
            $errors[] = 'İfade boş olamaz.';
            return ['valid' => false, 'errors' => $errors];
        }

        // Tehlikeli karakterler
        if (preg_match('/[`\'";$\\\\]/', $expression)) {
            $errors[] = 'İfade geçersiz karakterler içeriyor.';
            return ['valid' => false, 'errors' => $errors];
        }

        // Köşeli parantez için geçersiz kullanım kontrolü (x[], x[ gibi)
        if (preg_match('/\[\s*\]/', $expression) || preg_match('/\[\s*$/', $expression)) {
            $errors[] = 'Köşeli parantez kullanımı hatalı. x[0], x[1] gibi indeks belirtmelisiniz.';
            return ['valid' => false, 'errors' => $errors];
        }

        // Parantez dengesi
        $openCount = substr_count($expression, '(');
        $closeCount = substr_count($expression, ')');
        if ($openCount !== $closeCount) {
            $errors[] = 'Parantezler dengesiz.';
            return ['valid' => false, 'errors' => $errors];
        }

        // Köşeli parantez dengesi
        $openBracket = substr_count($expression, '[');
        $closeBracket = substr_count($expression, ']');
        if ($openBracket !== $closeBracket) {
            $errors[] = 'Köşeli parantezler dengesiz.';
            return ['valid' => false, 'errors' => $errors];
        }

        // Bilinmeyen fonksiyon kontrolü
        preg_match_all('/([a-zA-Z_][a-zA-Z0-9_]*)\s*\(/', $expression, $matches);
        foreach ($matches[1] as $func) {
            if (!in_array(strtolower($func), self::$allowedFunctions)) {
                $errors[] = "Bilinmeyen fonksiyon: {$func}";
            }
        }

        if (!empty($errors)) {
            return ['valid' => false, 'errors' => $errors];
        }

        // Sözdizimi kontrolü - basit test
        $testExpr = self::prepareExpression($expression, 2);
        
        // Eval öncesi güvenlik kontrolü
        $safeTestExpr = str_replace(['$x[0]', '$x[1]', '$x[2]', '$x[3]'], ['1', '1', '1', '1'], $testExpr);
        
        // Hala $x içeriyorsa geçersiz
        if (preg_match('/\$x\[/', $safeTestExpr)) {
            $errors[] = 'İfade geçersiz değişken referansı içeriyor.';
            return ['valid' => false, 'errors' => $errors];
        }
        
        try {
            $testResult = @eval("return " . $safeTestExpr . ";");
            
            if ($testResult === false && $testResult !== 0 && $testResult !== 0.0) {
                $lastError = error_get_last();
                if ($lastError) {
                    $errors[] = 'İfade sözdizimi hatası içeriyor.';
                }
            }
        } catch (\Throwable $e) {
            $errors[] = 'İfade değerlendirilemiyor: ' . $e->getMessage();
        }

        return [
            'valid' => empty($errors),
            'errors' => $errors
        ];
    }


    /**
     * İfadeyi PHP kodu olarak hazırla
     */
    public static function prepareExpression(string $expression, int $dimension = 2): string
    {
        // Temizle
        $expr = strtolower(trim($expression));
        
        // ^ operatörünü pow() fonksiyonuna çevir
        $expr = self::convertPowerOperator($expr);
        
        // x, y, z gibi değişkenleri x[0], x[1], x[2] olarak değiştir
        // Önce x0, x1, x2 vb. formatını dene
        $expr = preg_replace_callback('/x(\d+)/', function($m) {
            return '$x[' . $m[1] . ']';
        }, $expr);
        
        // Sonra tek harfli değişkenleri çevir (x, y, z, ...)
        $vars = ['x' => 0, 'y' => 1, 'z' => 2, 'w' => 3, 'v' => 4, 'u' => 5];
        foreach ($vars as $var => $idx) {
            // Sadece tek başına duran değişkenleri değiştir (fonksiyon adı parçası olmayanlar)
            $expr = preg_replace('/(?<![a-z])' . $var . '(?![a-z0-9\[])/', '$x[' . $idx . ']', $expr);
        }
        
        // pi() fonksiyonunu M_PI'ye çevir
        $expr = preg_replace('/\bpi\(\)/', 'M_PI', $expr);
        $expr = preg_replace('/\bpi\b/', 'M_PI', $expr);
        
        return $expr;
    }

    /**
     * ^ operatörünü pow() fonksiyonuna çevir
     */
    private static function convertPowerOperator(string $expr): string
    {
        // Basit durumlar için: a^b -> pow(a, b)
        while (preg_match('/([a-z0-9_\[\]\$\)]+)\s*\^\s*([a-z0-9_\[\]\$\(]+)/i', $expr, $match)) {
            $base = $match[1];
            $exp = $match[2];
            
            // Parantezli üs kontrolü
            if (substr($exp, 0, 1) === '(') {
                // Parantez içini bul
                $depth = 0;
                $end = 0;
                for ($i = 0; $i < strlen($exp); $i++) {
                    if ($exp[$i] === '(') $depth++;
                    if ($exp[$i] === ')') $depth--;
                    if ($depth === 0) {
                        $end = $i;
                        break;
                    }
                }
                $exp = substr($exp, 0, $end + 1);
            }
            
            $expr = str_replace($match[0], "pow($base, $exp)", $expr);
        }
        
        return $expr;
    }

    /**
     * İfadeden çalıştırılabilir fonksiyon oluştur
     */
    public static function createFunction(string $expression, int $dimension = 2): callable
    {
        $validation = self::validate($expression);
        if (!$validation['valid']) {
            throw new \InvalidArgumentException(implode(' ', $validation['errors']));
        }

        $preparedExpr = self::prepareExpression($expression, $dimension);
        
        return function(array $x) use ($preparedExpr, $dimension): float {
            // Güvenlik kontrolü
            if (count($x) < $dimension) {
                throw new \InvalidArgumentException("Yetersiz boyut: beklenen {$dimension}, gelen " . count($x));
            }
            
            try {
                $result = eval("return (float)({$preparedExpr});");
                
                if (!is_numeric($result) || is_nan($result) || is_infinite($result)) {
                    return PHP_FLOAT_MAX;
                }
                
                return (float)$result;
            } catch (\Throwable $e) {
                return PHP_FLOAT_MAX;
            }
        };
    }

    /**
     * Örnek ifadeler
     */
    public static function getExamples(): array
    {
        return [
            'x^2 + y^2' => 'Sphere (2D)',
            'x^2 + y^2 + z^2' => 'Sphere (3D)',
            'sin(x) + cos(y)' => 'Trigonometrik',
            '10*2 + (x^2 - 10*cos(2*pi()*x)) + (y^2 - 10*cos(2*pi()*y))' => 'Rastrigin (2D)',
            'abs(x) + abs(y)' => 'Mutlak Değer',
            'exp(-x^2 - y^2)' => 'Gaussian',
            'sqrt(x^2 + y^2)' => 'Euclidean Distance',
            '100*(y - x^2)^2 + (1-x)^2' => 'Rosenbrock (2D)',
        ];
    }
}
