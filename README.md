# Quizie Backend - Laravel Quiz Management System

A comprehensive Laravel-based quiz management system with AI-powered quiz generation capabilities.

## Features

### Core Features
- 🎯 Quiz Management (Create, Edit, Delete)
- 📝 Question Management with Multiple Choice Options
- 👥 User Management with Role-Based Permissions
- 📊 Subject Management
- 📈 Quiz Results & Analytics
- 🔐 Authentication & Authorization (Laravel Passport)

### AI-Powered Quiz Generation ✨
- **Multiple AI Providers Support**:
  - **OpenAI** (GPT-4o-mini) - Cloud-based, high quality
  - **Ollama** (Local) - FREE, no API costs, privacy-focused
  - **Google Gemini** - Cloud-based, cost-effective
- **Automatic Question Generation** based on topics
- **Configurable Difficulty Levels** (Easy, Medium, Hard)
- **AI Provider Settings UI** for easy configuration
- **Generate Quiz on Subject Creation** option

## Requirements

- PHP >= 8.2
- Composer
- MySQL/MariaDB
- Node.js & NPM (for frontend assets)
- **Optional**: Ollama (for local AI quiz generation)

## Installation

### 1. Clone Repository
```bash
git clone <repository-url>
cd quize_beckendV2
```

### 2. Install Dependencies
```bash
composer install
npm install
```

### 3. Environment Setup
```bash
cp .env.example .env
php artisan key:generate
```

### 4. Configure Database
Edit `.env` file:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database_name
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

### 5. Run Migrations
```bash
php artisan migrate --seed
```

### 6. Install Passport
```bash
php artisan passport:install
```

### 7. Configure AI Provider (Optional)

#### Option A: OpenAI
```env
AI_PROVIDER=openai
OPENAI_API_KEY=sk-your-api-key
```

#### Option B: Ollama (FREE Local AI)
```bash
# Install Ollama from https://ollama.ai
ollama pull llama3.1:8b
```
```env
AI_PROVIDER=ollama
OLLAMA_URL=http://localhost:11434
OLLAMA_MODEL=llama3.1:8b
```

#### Option C: Google Gemini
```env
AI_PROVIDER=gemini
GEMINI_API_KEY=your-gemini-api-key
```

### 8. Start Development Server
```bash
php artisan serve
```

## AI Quiz Generation Setup

### Recommended: Ollama (Local & Free)

**Why Ollama?**
- ✅ **Completely FREE** - No API costs
- ✅ **Privacy** - All data stays local
- ✅ **Fast** - No network latency
- ✅ **No Rate Limits** - Generate unlimited quizzes

**Installation:**
1. Download Ollama from [https://ollama.ai](https://ollama.ai)
2. Install and run Ollama
3. Pull recommended model:
   ```bash
   ollama pull llama3.1:8b
   ```
4. Configure in Settings UI (`/settings`)

**Recommended Models:**
- `llama3.1:8b` - Best overall quality (Recommended)
- `qwen2.5:7b` - Excellent JSON formatting
- `mistral:7b` - Fastest inference
- `gemma2:9b` - Best for educational content

### Alternative: Cloud Providers

**OpenAI (Best Quality)**
- Get API key: [https://platform.openai.com/api-keys](https://platform.openai.com/api-keys)
- Cost: ~$0.01-0.02 per 10 questions

**Google Gemini (Cost-Effective)**
- Get API key: [https://makersuite.google.com/app/apikey](https://makersuite.google.com/app/apikey)
- Cost: ~$0.005-0.01 per 10 questions

## Usage

### Access Admin Panel
```
http://localhost:8000/home
```

### Configure AI Provider
1. Navigate to `/settings`
2. Select your preferred AI provider
3. Enter configuration details
4. Test connection
5. Save settings

### Generate Quiz with AI

**Method 1: Standalone Generation**
1. Go to "Create Quiz with AI" (`/create/quiz/ai`)
2. Enter topic, difficulty, and number of questions
3. Upload quiz image
4. Click "Generate Quiz with AI"

**Method 2: During Subject Creation**
1. Go to "Create Subject"
2. Enter subject details
3. ✅ Check "Generate Quiz & Questions with AI"
4. Configure AI settings
5. Create subject - Quiz generated automatically!

## Project Structure

```
app/
├── Http/Controllers/
│   └── Web/
│       ├── QuizController.php
│       ├── QuestionController.php
│       ├── SubjectController.php
│       ├── SettingsController.php
│       └── ...
├── Models/
│   ├── Quiz.php
│   ├── Question.php
│   ├── Subject.php
│   ├── Setting.php
│   └── ...
└── Services/AI/
    ├── AIProviderInterface.php
    ├── AIServiceFactory.php
    ├── OpenAIService.php
    ├── OllamaService.php
    └── GeminiService.php

resources/views/
├── admin/
│   ├── quiz-ai-generate.blade.php
│   ├── settings/
│   │   └── index.blade.php
│   └── ...
└── subject/
    └── create.blade.php
```

## Key Features Explained

### AI Provider System
- **Factory Pattern**: Automatic provider switching
- **Interface-Based**: Easy to add new providers
- **Settings Management**: UI-based configuration
- **Test Connection**: Verify setup before use

### Quiz Answer Convention
⚠️ **Important**: The correct answer is always in `option1`
- `option1` = Correct answer
- `option2`, `option3`, `option4` = Incorrect options

## API Endpoints

### Authentication
```
POST /api/login
POST /api/register
```

### Quiz Management
```
GET  /api/quiz/{subject}
GET  /api/quiz/{quiz_id}/single
```

### Results
```
POST /api/result
GET  /api/results/{quiz_id}
```

## Technologies Used

- **Framework**: Laravel 11
- **Authentication**: Laravel Passport
- **Permissions**: Spatie Laravel Permission
- **PDF Generation**: DomPDF
- **Excel**: Maatwebsite Excel
- **DataTables**: Yajra DataTables
- **AI Integration**: 
  - OpenAI PHP Client
  - Google Gemini PHP Client
  - HTTP Client (for Ollama)

## Cost Comparison

| Provider | 10 Questions | 50 Questions | Quality | Speed |
|----------|-------------|--------------|---------|-------|
| Ollama   | **FREE**    | **FREE**    | ⭐⭐⭐⭐ | Very Fast |
| Gemini   | $0.005-0.01 | $0.025-0.05 | ⭐⭐⭐⭐ | Fast |
| OpenAI   | $0.01-0.02  | $0.05-0.10  | ⭐⭐⭐⭐⭐ | Fast |

## Troubleshooting

### Ollama Connection Issues
```bash
# Check if Ollama is running
ollama list

# Start Ollama
ollama serve

# Pull model if not available
ollama pull llama3.1:8b
```

### Migration Issues
```bash
# Fresh migration
php artisan migrate:fresh --seed

# Clear cache
php artisan config:clear
php artisan cache:clear
```

### Permission Issues
```bash
# Fix storage permissions
chmod -R 775 storage bootstrap/cache
```

## Contributing

1. Fork the repository
2. Create your feature branch
3. Commit your changes
4. Push to the branch
5. Create a Pull Request

## License

This project is open-sourced software licensed under the MIT license.

## Support

For issues and questions, please open an issue on GitHub.

## Changelog

### Latest Updates
- ✅ Upgraded to Laravel 11
- ✅ Added multi-AI provider support (OpenAI, Ollama, Gemini)
- ✅ Implemented AI quiz generation
- ✅ Added Settings UI for AI configuration
- ✅ Added AI generation option to subject creation
- ✅ Updated dependencies for Laravel 11 compatibility

---

**Made with ❤️ using Laravel**
