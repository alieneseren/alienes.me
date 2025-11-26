// Common JavaScript Functions

// Tab Switching
function showTab(tabName) {
    document.querySelectorAll('.tab-content').forEach(content => {
        content.classList.remove('active');
    });
    document.querySelectorAll('.tab').forEach(tab => {
        tab.classList.remove('active');
    });
    document.getElementById(tabName).classList.add('active');
    event.target.classList.add('active');
}

// Test Initialization
function initTest(containerId, progressId, resultId, questions, moduleName) {
    let currentState = [];
    let answeredCount = 0;
    
    const container = document.getElementById(containerId);
    container.innerHTML = '';
    
    questions.forEach((q, index) => {
        const questionDiv = document.createElement('div');
        questionDiv.className = 'test-question';
        questionDiv.innerHTML = `
            <h3>Soru ${index + 1}</h3>
            <p>${q.q}</p>
            <ul class="test-options" id="options-${index}">
                ${q.options.map((opt, optIndex) => 
                    `<li onclick="selectAnswer(${index}, ${optIndex})">${opt}</li>`
                ).join('')}
            </ul>
        `;
        container.appendChild(questionDiv);
        currentState.push(null);
    });
    
    window.selectAnswer = function(questionIndex, answerIndex) {
        if (currentState[questionIndex] !== null) return;
        
        currentState[questionIndex] = answerIndex;
        answeredCount++;
        
        const optionsList = document.getElementById(`options-${questionIndex}`);
        const options = optionsList.querySelectorAll('li');
        
        const isCorrect = answerIndex === questions[questionIndex].correct;
        options[answerIndex].classList.add(isCorrect ? 'correct' : 'incorrect');
        
        if (!isCorrect) {
            options[questions[questionIndex].correct].classList.add('correct');
        }
        
        options.forEach(opt => opt.classList.add('disabled'));
        
        updateProgress();
        
        if (answeredCount === questions.length) {
            showResults();
        }
    };
    
    function updateProgress() {
        const progress = document.getElementById(progressId);
        progress.textContent = `${answeredCount}/${questions.length}`;
        progress.style.width = `${(answeredCount / questions.length) * 100}%`;
    }
    
    function showResults() {
        const correctAnswers = currentState.filter((answer, index) => 
            answer === questions[index].correct
        ).length;
        
        const percentage = (correctAnswers / questions.length) * 100;
        const resultDiv = document.getElementById(resultId);
        
        let message = '';
        let resultClass = '';
        
        if (percentage >= 90) {
            message = '🎉 Mükemmel!';
            resultClass = 'result-excellent';
        } else if (percentage >= 70) {
            message = '👏 Çok İyi! Geçtiniz!';
            resultClass = 'result-good';
        } else if (percentage >= 50) {
            message = '👍 İyi! Ama daha fazla çalışmalısınız.';
            resultClass = 'result-pass';
        } else {
            message = '📚 Konuyu tekrar etmeniz gerekiyor.';
            resultClass = 'result-fail';
        }
        
        resultDiv.innerHTML = `
            <div class="result-box ${resultClass}">
                <h2>${message}</h2>
                <p style="font-size: 2em; margin: 20px 0;">${correctAnswers} / ${questions.length}</p>
                <p>Başarı Oranı: %${percentage.toFixed(1)}</p>
            </div>
        `;
        
        // Save score to localStorage
        localStorage.setItem(`${moduleName}_score`, percentage);
        localStorage.setItem(`${moduleName}_date`, new Date().toISOString());
    }
    
    window.resetTest = function() {
        currentState = [];
        answeredCount = 0;
        document.getElementById(resultId).innerHTML = '';
        initTest(containerId, progressId, resultId, questions, moduleName);
    };
}

// Flashcards Initialization
function initFlashcards(containerId, flashcards) {
    const container = document.getElementById(containerId);
    container.innerHTML = '';
    
    flashcards.forEach((card, index) => {
        const cardDiv = document.createElement('div');
        cardDiv.className = 'flashcard';
        cardDiv.id = `flashcard-${index}`;
        cardDiv.innerHTML = `<div class="flashcard-front">${card.front}</div>`;
        cardDiv.onclick = () => toggleFlashcard(index);
        container.appendChild(cardDiv);
    });
    
    function toggleFlashcard(index) {
        const card = document.getElementById(`flashcard-${index}`);
        const isFlipped = card.classList.contains('flipped');
        
        card.classList.toggle('flipped');
        card.innerHTML = isFlipped ? 
            `<div class="flashcard-front">${flashcards[index].front}</div>` :
            `<div class="flashcard-back">${flashcards[index].back}</div>`;
    }
}

// Toggle Solution (for practice problems)
function toggleSolution(solId) {
    const sol = document.getElementById(solId);
    if (sol.style.display === 'none' || sol.style.display === '') {
        sol.style.display = 'block';
    } else {
        sol.style.display = 'none';
    }
}

// Get module progress
function getModuleProgress(moduleName) {
    const score = localStorage.getItem(`${moduleName}_score`);
    const date = localStorage.getItem(`${moduleName}_date`);
    
    return {
        score: score ? parseFloat(score) : 0,
        date: date ? new Date(date) : null,
        completed: score && parseFloat(score) >= 70
    };
}

// Calculate total progress
function calculateTotalProgress() {
    const modules = ['modul1', 'modul2', 'modul3', 'modul4', 'modul5', 'modul6', 'modul7', 'modul8'];
    let completed = 0;
    
    modules.forEach(mod => {
        const progress = getModuleProgress(mod);
        if (progress.completed) completed++;
    });
    
    return (completed / modules.length) * 100;
}

// Format date
function formatDate(date) {
    if (!date) return 'Henüz tamamlanmadı';
    return date.toLocaleDateString('tr-TR', { 
        day: 'numeric', 
        month: 'long', 
        year: 'numeric' 
    });
}

// Number system conversions (for Module 3)
function decimalToBinary(decimal) {
    return (decimal >>> 0).toString(2);
}

function binaryToDecimal(binary) {
    return parseInt(binary, 2);
}

function decimalToHex(decimal) {
    return decimal.toString(16).toUpperCase();
}

function hexToDecimal(hex) {
    return parseInt(hex, 16);
}

// Calculate addressable memory
function calculateAddressableMemory(addressBits) {
    return Math.pow(2, addressBits);
}

// Calculate required address bits
function calculateRequiredAddressBits(memorySize) {
    return Math.ceil(Math.log2(memorySize));
}

// Calculate data transfer rate
function calculateDataTransferRate(clockSpeed, busWidth) {
    return clockSpeed * busWidth;
}

// Smooth scroll to top
function scrollToTop() {
    window.scrollTo({ top: 0, behavior: 'smooth' });
}

// Print current page
function printPage() {
    window.print();
}

// Export progress as JSON
function exportProgress() {
    const progress = {
        modules: {},
        exportDate: new Date().toISOString()
    };
    
    const modules = ['modul1', 'modul2', 'modul3', 'modul4', 'modul5', 'modul6', 'modul7', 'modul8'];
    modules.forEach(mod => {
        progress.modules[mod] = getModuleProgress(mod);
    });
    
    const dataStr = JSON.stringify(progress, null, 2);
    const dataBlob = new Blob([dataStr], { type: 'application/json' });
    const url = URL.createObjectURL(dataBlob);
    const link = document.createElement('a');
    link.href = url;
    link.download = 'mikroislemciler-progress.json';
    link.click();
}

// Clear all progress
function clearAllProgress() {
    if (confirm('Tüm ilerleme verileriniz silinecek. Emin misiniz?')) {
        localStorage.clear();
        alert('Tüm veriler silindi!');
        location.reload();
    }
}

// Quiz timer
let quizTimer;
let quizSeconds = 0;

function startQuizTimer() {
    quizSeconds = 0;
    quizTimer = setInterval(() => {
        quizSeconds++;
        updateTimerDisplay();
    }, 1000);
}

function stopQuizTimer() {
    clearInterval(quizTimer);
}

function updateTimerDisplay() {
    const minutes = Math.floor(quizSeconds / 60);
    const seconds = quizSeconds % 60;
    const timerDisplay = document.getElementById('quizTimer');
    if (timerDisplay) {
        timerDisplay.textContent = `${minutes}:${seconds.toString().padStart(2, '0')}`;
    }
}

// Save note for a module
function saveNote(moduleName, note) {
    localStorage.setItem(`${moduleName}_note`, note);
}

function getNote(moduleName) {
    return localStorage.getItem(`${moduleName}_note`) || '';
}

// Bookmark a question
function toggleBookmark(moduleName, questionIndex) {
    const key = `${moduleName}_bookmarks`;
    let bookmarks = JSON.parse(localStorage.getItem(key) || '[]');
    
    const index = bookmarks.indexOf(questionIndex);
    if (index > -1) {
        bookmarks.splice(index, 1);
    } else {
        bookmarks.push(questionIndex);
    }
    
    localStorage.setItem(key, JSON.stringify(bookmarks));
    return bookmarks.includes(questionIndex);
}

function getBookmarks(moduleName) {
    const key = `${moduleName}_bookmarks`;
    return JSON.parse(localStorage.getItem(key) || '[]');
}

// Search functionality
function searchContent(query) {
    const lowerQuery = query.toLowerCase();
    const sections = document.querySelectorAll('.section');
    let found = false;
    
    sections.forEach(section => {
        const text = section.textContent.toLowerCase();
        if (text.includes(lowerQuery)) {
            section.style.display = 'block';
            section.style.backgroundColor = '#fff9c4';
            found = true;
        } else {
            section.style.display = 'none';
        }
    });
    
    return found;
}

function clearSearch() {
    const sections = document.querySelectorAll('.section');
    sections.forEach(section => {
        section.style.display = 'block';
        section.style.backgroundColor = '';
    });
}

console.log('📚 Mikroişlemciler Vize Hazırlık Platformu Yüklendi');
console.log('✅ Ortak fonksiyonlar hazır');