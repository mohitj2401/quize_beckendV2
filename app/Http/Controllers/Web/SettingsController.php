<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Services\AI\AIServiceFactory;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display settings page
     */
    public function index()
    {
        if (!(auth()->user()->can('View Settings') || in_array('Owner', auth()->user()->getRoleNames()->toArray()))) {
            alert()->error("You Don't Have Enough Permission", 'Request Denied');
            return redirect()->back();
        }

        $data['title'] = 'Settings | Quizie';
        $data['active'] = 'settings';
        $data['aiProvider'] = Setting::get('ai_provider', 'openai');
        $data['providers'] = AIServiceFactory::getAvailableProviders();
        
        // Get current settings
        $data['settings'] = [
            'openai_key' => Setting::get('openai_api_key', ''),
            'ollama_url' => Setting::get('ollama_url', 'http://localhost:11434'),
            'ollama_model' => Setting::get('ollama_model', 'llama3.1:8b'),
            'gemini_key' => Setting::get('gemini_api_key', ''),
        ];

        return view('admin.settings.index', $data);
    }

    /**
     * Update AI provider settings
     */
    public function updateAIProvider(Request $request)
    {
        if (!(auth()->user()->can('Edit Settings') || in_array('Owner', auth()->user()->getRoleNames()->toArray()))) {
            alert()->error("You Don't Have Enough Permission", 'Request Denied');
            return redirect()->back();
        }

        $request->validate([
            'ai_provider' => 'required|in:openai,ollama,gemini',
        ]);

        // Save AI provider
        Setting::set('ai_provider', $request->ai_provider, 'string', 'Active AI provider for quiz generation');

        // Save provider-specific settings
        if ($request->ai_provider === 'openai' && $request->filled('openai_api_key')) {
            Setting::set('openai_api_key', $request->openai_api_key, 'string', 'OpenAI API Key');
        }

        if ($request->ai_provider === 'ollama') {
            if ($request->filled('ollama_url')) {
                Setting::set('ollama_url', $request->ollama_url, 'string', 'Ollama API URL');
            }
            if ($request->filled('ollama_model')) {
                Setting::set('ollama_model', $request->ollama_model, 'string', 'Ollama Model Name');
            }
        }

        if ($request->ai_provider === 'gemini' && $request->filled('gemini_api_key')) {
            Setting::set('gemini_api_key', $request->gemini_api_key, 'string', 'Google Gemini API Key');
        }

        alert()->success('AI Provider settings updated successfully');
        return redirect()->back();
    }

    /**
     * Test AI provider connection
     */
    public function testProvider(Request $request)
    {
        try {
            $aiService = AIServiceFactory::make();
            
            // Try to generate a simple test
            $result = $aiService->generateQuizMetadata('Test Topic');
            
            if (isset($result['title'])) {
                return response()->json([
                    'success' => true,
                    'message' => 'AI provider is working correctly!',
                    'test_result' => $result
                ]);
            }

            return response()->json([
                'success' => false,
                'message' => 'Invalid response from AI provider'
            ], 500);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }
}
