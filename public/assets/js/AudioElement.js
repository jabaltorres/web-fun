class AudioElement {
    constructor(containerSelector, options) {
        this.container = document.querySelector(containerSelector);
        this.audio = this.container.querySelector('audio');
        this.playPauseBtn = this.container.querySelector(options.playPauseSelector);
        this.stopBtn = this.container.querySelector(options.stopSelector);
        this.progressBar = this.container.querySelector(options.progressBarSelector);
        this.timeDisplay = this.container.querySelector(options.timeDisplaySelector);
        
        this.initializeState();
        this.attachEventListeners();
    }

    initializeState() {
        // Restore previous state
        const savedTime = localStorage.getItem('audioCurrentTime');
        const wasPlaying = localStorage.getItem('audioIsPlaying') === 'true';
        
        if (savedTime) {
            this.audio.currentTime = parseFloat(savedTime);
        }
        
        if (wasPlaying) {
            this.play();
        }
    }

    attachEventListeners() {
        this.playPauseBtn.addEventListener('click', () => this.togglePlayPause());
        this.stopBtn.addEventListener('click', () => this.stop());
        
        this.audio.addEventListener('timeupdate', () => {
            this.updateProgress();
            this.saveState();
        });
        
        this.audio.addEventListener('ended', () => {
            this.stop();
            localStorage.removeItem('audioIsPlaying');
        });
        
        // Save state before page unload
        window.addEventListener('beforeunload', () => {
            this.saveState();
        });
    }

    togglePlayPause() {
        if (this.audio.paused) {
            this.play();
        } else {
            this.pause();
        }
    }

    play() {
        this.audio.play();
        this.playPauseBtn.innerHTML = '<i class="fa-solid fa-pause"></i>';
        localStorage.setItem('audioIsPlaying', 'true');
    }

    pause() {
        this.audio.pause();
        this.playPauseBtn.innerHTML = '<i class="fa-solid fa-play"></i>';
        localStorage.setItem('audioIsPlaying', 'false');
    }

    stop() {
        this.audio.pause();
        this.audio.currentTime = 0;
        this.playPauseBtn.innerHTML = '<i class="fa-solid fa-play"></i>';
        this.updateProgress();
        localStorage.setItem('audioIsPlaying', 'false');
        localStorage.removeItem('audioCurrentTime');
    }

    updateProgress() {
        const percent = (this.audio.currentTime / this.audio.duration) * 100;
        this.progressBar.style.width = `${percent}%`;
        
        const minutes = Math.floor(this.audio.currentTime / 60);
        const seconds = Math.floor(this.audio.currentTime % 60).toString().padStart(2, '0');
        this.timeDisplay.textContent = `${minutes}:${seconds}`;
    }

    saveState() {
        localStorage.setItem('audioCurrentTime', this.audio.currentTime.toString());
    }
} 