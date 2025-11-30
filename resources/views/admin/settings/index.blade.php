@extends('admin.layouts.admin')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">AI Provider Settings</h6>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('settings.ai-provider') }}" method="POST">
                            @csrf

                            <div class="alert alert-info">
                                <i class="fas fa-info-circle"></i> <strong>Select AI Provider</strong><br>
                                Choose which AI service to use for quiz and question generation.
                            </div>

                            <!-- Provider Selection -->
                            <div class="form-group">
                                <label class="font-weight-bold">Active AI Provider</label>
                                <div class="row">
                                    @foreach($providers as $key => $provider)
                                        <div class="col-md-4">
                                            <div class="card {{ $aiProvider == $key ? 'border-primary' : '' }} mb-3">
                                                <div class="card-body">
                                                    <div class="custom-control custom-radio">
                                                        <input type="radio" id="provider_{{ $key }}" 
                                                               name="ai_provider" value="{{ $key }}" 
                                                               class="custom-control-input provider-radio"
                                                               {{ $aiProvider == $key ? 'checked' : '' }}>
                                                        <label class="custom-control-label" for="provider_{{ $key }}">
                                                            <strong>{{ $provider['name'] }}</strong>
                                                        </label>
                                                    </div>
                                                    <small class="text-muted d-block mt-2">
                                                        {{ $provider['description'] }}
                                                    </small>
                                                    @if($key == 'ollama')
                                                        <span class="badge badge-success mt-2">FREE - No API Costs</span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            <hr>

                            <!-- OpenAI Settings -->
                            <div id="openai_settings" class="provider-settings" style="display: {{ $aiProvider == 'openai' ? 'block' : 'none' }};">
                                <h5 class="text-primary"><i class="fas fa-robot"></i> OpenAI Configuration</h5>
                                <div class="form-group">
                                    <label for="openai_api_key">API Key</label>
                                    <input type="password" class="form-control" id="openai_api_key" 
                                           name="openai_api_key" value="{{ $settings['openai_key'] }}"
                                           placeholder="sk-...">
                                    <small class="form-text text-muted">
                                        Get your API key from <a href="https://platform.openai.com/api-keys" target="_blank">OpenAI Platform</a>
                                    </small>
                                </div>
                            </div>

                            <!-- Ollama Settings -->
                            <div id="ollama_settings" class="provider-settings" style="display: {{ $aiProvider == 'ollama' ? 'block' : 'none' }};">
                                <h5 class="text-success"><i class="fas fa-server"></i> Ollama Configuration (Local AI)</h5>
                                <div class="alert alert-success">
                                    <strong>FREE Local AI!</strong> No API costs. Requires Ollama installed locally.
                                    <a href="https://ollama.ai" target="_blank">Download Ollama</a>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="ollama_url">Ollama URL</label>
                                            <input type="text" class="form-control" id="ollama_url" 
                                                   name="ollama_url" value="{{ $settings['ollama_url'] }}"
                                                   placeholder="http://localhost:11434">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="ollama_model">Model Name</label>
                                            <select class="form-control" id="ollama_model" name="ollama_model">
                                                <option value="llama3.1:8b" {{ $settings['ollama_model'] == 'llama3.1:8b' ? 'selected' : '' }}>llama3.1:8b (Recommended)</option>
                                                <option value="qwen2.5:7b" {{ $settings['ollama_model'] == 'qwen2.5:7b' ? 'selected' : '' }}>qwen2.5:7b (Best JSON)</option>
                                                <option value="mistral:7b" {{ $settings['ollama_model'] == 'mistral:7b' ? 'selected' : '' }}>mistral:7b (Fast)</option>
                                                <option value="gemma2:9b" {{ $settings['ollama_model'] == 'gemma2:9b' ? 'selected' : '' }}>gemma2:9b (Educational)</option>
                                            </select>
                                            <small class="form-text text-muted">
                                                Pull model: <code>ollama pull llama3.1:8b</code>
                                            </small>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Gemini Settings -->
                            <div id="gemini_settings" class="provider-settings" style="display: {{ $aiProvider == 'gemini' ? 'block' : 'none' }};">
                                <h5 class="text-info"><i class="fas fa-brain"></i> Google Gemini Configuration</h5>
                                <div class="form-group">
                                    <label for="gemini_api_key">API Key</label>
                                    <input type="password" class="form-control" id="gemini_api_key" 
                                           name="gemini_api_key" value="{{ $settings['gemini_key'] }}"
                                           placeholder="AIza...">
                                    <small class="form-text text-muted">
                                        Get your API key from <a href="https://makersuite.google.com/app/apikey" target="_blank">Google AI Studio</a>
                                    </small>
                                </div>
                            </div>

                            <hr>

                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save"></i> Save Settings
                                </button>
                                <button type="button" class="btn btn-info" id="test-provider-btn">
                                    <i class="fas fa-vial"></i> Test Connection
                                </button>
                            </div>
                        </form>

                        <div id="test-result" class="mt-3" style="display: none;"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script>
    // Show/hide provider settings based on selection
    document.querySelectorAll('.provider-radio').forEach(radio => {
        radio.addEventListener('change', function() {
            // Hide all provider settings
            document.querySelectorAll('.provider-settings').forEach(div => {
                div.style.display = 'none';
            });
            
            // Show selected provider settings
            const provider = this.value;
            document.getElementById(provider + '_settings').style.display = 'block';
            
            // Update card borders
            document.querySelectorAll('.provider-radio').forEach(r => {
                r.closest('.card').classList.remove('border-primary');
            });
            this.closest('.card').classList.add('border-primary');
        });
    });

    // Test provider connection
    document.getElementById('test-provider-btn').addEventListener('click', function() {
        const btn = this;
        const resultDiv = document.getElementById('test-result');
        
        btn.disabled = true;
        btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Testing...';
        
        fetch('{{ route("settings.test-provider") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        })
        .then(response => response.json())
        .then(data => {
            resultDiv.style.display = 'block';
            if (data.success) {
                resultDiv.className = 'alert alert-success';
                resultDiv.innerHTML = '<i class="fas fa-check-circle"></i> ' + data.message;
            } else {
                resultDiv.className = 'alert alert-danger';
                resultDiv.innerHTML = '<i class="fas fa-exclamation-circle"></i> ' + data.message;
            }
        })
        .catch(error => {
            resultDiv.style.display = 'block';
            resultDiv.className = 'alert alert-danger';
            resultDiv.innerHTML = '<i class="fas fa-exclamation-circle"></i> Connection failed: ' + error.message;
        })
        .finally(() => {
            btn.disabled = false;
            btn.innerHTML = '<i class="fas fa-vial"></i> Test Connection';
        });
    });
</script>
@endsection
