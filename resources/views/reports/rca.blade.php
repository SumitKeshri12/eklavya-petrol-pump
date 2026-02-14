<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Root Cause Analysis Report</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 900px;
            margin: 0 auto;
            padding: 40px;
            background-color: #f9fafb;
        }

        h1 {
            color: #1a202c;
            border-bottom: 2px solid #3182ce;
            padding-bottom: 10px;
        }

        h2 {
            color: #2d3748;
            margin-top: 30px;
            border-left: 4px solid #3182ce;
            padding-left: 10px;
        }

        .header-info {
            background-color: #ebf8ff;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 30px;
        }

        .metric {
            display: inline-block;
            margin-right: 20px;
            font-weight: bold;
        }

        .severity-Critical {
            color: #e53e3e;
            font-weight: bold;
        }

        .severity-High {
            color: #dd6b20;
            font-weight: bold;
        }

        .severity-Medium {
            color: #d69e2e;
            font-weight: bold;
        }

        .severity-Low {
            color: #38a169;
            font-weight: bold;
        }

        .cluster-box {
            background: white;
            padding: 20px;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            margin-bottom: 20px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        }

        .cluster-header {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
            border-bottom: 1px solid #edf2f7;
            padding-bottom: 5px;
        }

        .cluster-body {
            font-family: 'Courier New', Courier, monospace;
            background: #2d3748;
            color: #a0aec0;
            padding: 10px;
            border-radius: 4px;
            font-size: 0.85rem;
            white-space: pre-wrap;
            overflow-x: auto;
        }

        .rca-box {
            background-color: #fffaf0;
            border: 1px solid #feebc8;
            padding: 20px;
            border-radius: 8px;
            margin-top: 20px;
        }

        .confidence {
            font-size: 0.9rem;
            color: #718096;
            margin-top: 5px;
        }

        .recommendations-list {
            margin-top: 20px;
        }

        .recommendation-item {
            background: #f0fff4;
            border-left: 4px solid #48bb78;
            padding: 10px;
            margin-bottom: 10px;
        }

        @media print {
            body {
                background: white;
                padding: 0;
            }

            .cluster-box {
                break-inside: avoid;
            }
        }
    </style>
</head>

<body>
    <h1>Root Cause Analysis Report</h1>

    <div class="header-info">
        <div class="metric">Generated: {{ $timestamp }}</div>
        <div class="metric">Logs Analyzed: {{ $log_summary['total_lines'] }} items</div>
        <div class="metric">Unique Clusters Found: {{ $log_summary['unique_clusters'] }}</div>
    </div>

    <h2>Probable Root Causes (AI Analysis)</h2>
    @php $rootCauses = $results['root_causes'] ?? ($analysis['root_causes'] ?? []); @endphp

    @if (!empty($rootCauses))
        @foreach ($rootCauses as $rc)
            <div class="rca-box">
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <strong style="font-size: 1.2rem;">{{ $rc['cause'] }}</strong>
                    <span
                        class="severity-{{ $rc['severity'] ?? 'Low' }}">{{ strtoupper($rc['severity'] ?? 'Low') }}</span>
                </div>
                <p>{{ $rc['description'] }}</p>
                <div class="confidence">AI Confidence Level: {{ number_format(($rc['confidence'] ?? 0) * 100, 1) }}%
                </div>
            </div>
        @endforeach
    @else
        <p>No specific root causes identified or AI analysis failed.</p>
    @endif

    <h2>Recommendations</h2>
    <div class="recommendations-list">
        @php $recs = $results['recommendations'] ?? ($analysis['recommendations'] ?? []); @endphp
        @foreach ($recs as $rec)
            <div class="recommendation-item">
                {{ $rec }}
            </div>
        @endforeach
    </div>

</body>

</html>
