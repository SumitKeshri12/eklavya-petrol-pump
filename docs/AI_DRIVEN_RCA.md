# AI-Powered Incident & Root Cause Analyzer (RCA)

This project implements an AI-driven log and metric analyzer to identify system issues and suggest resolutions using Gemini AI.

## 🚀 API Demo

### Log & Metric Intake
**Endpoint**: `POST /api/v1/rca/analyze`

**Payload**:
```json
{
  "logs": [
    "[2026-02-14 11:10:00] local.ERROR: SQLSTATE[HY000] [2002] Connection refused (mysql:3306)",
    "[2026-02-14 11:12:00] local.ERROR: SQLSTATE[HY000] [2002] Connection refused (mysql:3306)"
  ],
  "metrics": {
    "db_connections": 150,
    "latency": 2500,
    "cpu_usage": 98
  }
}
```

**Response**:
```json
{
  "likely_cause": "Database Connection Pool Exhaustion",
  "confidence": 0.92,
  "next_steps": "Increase max_connections in MySQL or optimize connection pooling in the app."
}
```

### Report Export
- **HTML Preview**: `GET /api/v1/rca/analyze?format=html`
- **DOCX Download**: `GET /api/v1/rca/analyze?format=docx`

---

## 🧠 AI Integration Details

### Prompts Used

**System/Instruction Prompt**:
> "Analyze the following clustered Laravel log entries and provide a structured Root Cause Analysis in JSON format. The input contains unique error clusters and a metric summary of the server state. Return results ONLY as a valid JSON object. Do not include markdown formatting like ```json."

**Data Payload Format**:
> "--- Metric Summary ---
> { ...metrics... }
> 
> --- Clustered Log Events ---
> - [Count: 5, Severity: High] SQLSTATE[HY000] [2002] ...
> 
> Suggest probable root causes and reasoning. Return results ONLY as a valid JSON object with 'root_causes' (array) and 'recommendations' (strings)."

### Observed AI Mistakes

1. **Markdown Formatting**: The AI frequently wrapped the JSON response in ```json ``` code blocks, which caused `json_decode` to fail in PHP.
2. **Schema Hallucination**: Occasionally, the AI would omit required fields (like `confidence` or `severity`) or invent new field names not defined in the prompt.
3. **Configuration Recommendations**: The AI initially suggested using `responseMimeType: 'application/json'` in the API request, which is not supported by all Gemini model versions (causing 400 errors).

### Mitigation Strategies

- **Strict Parsing Logic**: Implemented a cleanup method in `AiService` that uses regex to strip any markdown code blocks from the AI's response before decoding.
- **Explicit Schema Definition**: Finalized a prompt that includes a literal JSON schema example to "anchor" the AI's output structure.
- **Prompt-Based JSON Enforcement**: Removed the `responseMimeType` parameter and instead added "Return results ONLY as a valid JSON object" at the end of the prompt, which proved more reliable for the current model.
- **Heuristic Ranking**: Added a backend "Decision Layer" that manually ranks AI suggestions and correlates them with metric spikes to verified likelihood before presenting the "Likely Cause".
