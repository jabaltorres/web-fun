class AudioElement {
    static instance = null; // Singleton instance

    // Constants for local storage keys
    static AUDIO_CURRENT_TIME_KEY = 'audioCurrentTime';
    static AUDIO_IS_PLAYING_KEY = 'audioIsPlaying';

    constructor(containerSelector, options) {
        // Initializes the AudioElement instance, setting up the audio player and event listeners
        if (AudioElement.instance) {
            return AudioElement.instance; // Return existing instance
        }

        this.container = document.querySelector(containerSelector);
        this.audio = this.container.querySelector('audio');
        this.playPauseBtn = this.container.querySelector(options.playPauseSelector);
        this.stopBtn = this.container.querySelector(options.stopSelector);
        this.progressBar = this.container.querySelector(options.progressBarSelector);
        this.timeDisplay = this.container.querySelector(options.timeDisplaySelector);
        
        this.initializeState();
        this.attachEventListeners();

        AudioElement.instance = this; // Set the singleton instance
    }

    // Initializes the audio player state by restoring the previous playback position and state
    initializeState() {
        const savedTime = localStorage.getItem(AudioElement.AUDIO_CURRENT_TIME_KEY);
        const wasPlaying = localStorage.getItem(AudioElement.AUDIO_IS_PLAYING_KEY) === 'true';
        
        if (savedTime) {
            this.audio.currentTime = parseFloat(savedTime);
        }
        
        if (wasPlaying) {
            this.play();
        }
    }

    // Attaches event listeners for play/pause, stop, time update, and page unload
    attachEventListeners() {
        this.playPauseBtn.addEventListener('click', () => this.togglePlayPause());
        this.stopBtn.addEventListener('click', () => this.stop());
        
        this.audio.addEventListener('timeupdate', () => {
            this.updateProgress();
            this.saveState();
        });
        
        this.audio.addEventListener('ended', () => {
            this.stop();
            localStorage.removeItem(AudioElement.AUDIO_IS_PLAYING_KEY);
        });
        
        window.addEventListener('beforeunload', () => this.saveState());
    }

    // Toggles between play and pause states
    togglePlayPause() {
        this.audio.paused ? this.play() : this.pause();
    }

    // Plays the audio and updates the play/pause button
    play() {
        this.audio.play().catch(error => console.error('Playback failed:', error));
        this.updatePlayPauseButton('pause');
        localStorage.setItem(AudioElement.AUDIO_IS_PLAYING_KEY, 'true');
    }

    // Pauses the audio and updates the play/pause button
    pause() {
        this.audio.pause();
        this.updatePlayPauseButton('play');
        localStorage.setItem(AudioElement.AUDIO_IS_PLAYING_KEY, 'false');
    }

    // Stops the audio, resets the current time, and updates the play/pause button
    stop() {
        this.audio.pause();
        this.audio.currentTime = 0;
        this.updatePlayPauseButton('play');
        this.updateProgress();
        localStorage.setItem(AudioElement.AUDIO_IS_PLAYING_KEY, 'false');
        localStorage.removeItem(AudioElement.AUDIO_CURRENT_TIME_KEY);
    }

    // Updates the play/pause button based on the current action
    updatePlayPauseButton(action) {
        this.playPauseBtn.innerHTML = action === 'pause' 
            ? '<i class="fa-solid fa-pause"></i>' 
            : '<i class="fa-solid fa-play"></i>';
    }

    // Updates the progress bar and time display based on the current playback position
    updateProgress() {
        const percent = (this.audio.currentTime / this.audio.duration) * 100;
        this.progressBar.style.width = `${percent}%`;
        
        const minutes = Math.floor(this.audio.currentTime / 60);
        const seconds = Math.floor(this.audio.currentTime % 60).toString().padStart(2, '0');
        this.timeDisplay.textContent = `${minutes}:${seconds}`;
    }

    // Saves the current playback time to local storage
    saveState() {
        localStorage.setItem(AudioElement.AUDIO_CURRENT_TIME_KEY, this.audio.currentTime.toString());
    }
} 