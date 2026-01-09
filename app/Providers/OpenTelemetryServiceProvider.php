<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use OpenTelemetry\SDK\Trace\TracerProvider;
use OpenTelemetry\SDK\Trace\SpanProcessor\SimpleSpanProcessor;
use OpenTelemetry\Contrib\Otlp\SpanExporter as OtlpSpanExporter;

class OpenTelemetryServiceProvider extends ServiceProvider
{
    public function register()
    {
        // $exporter = new OtlpSpanExporter(
        //     endpoint: env('OTEL_EXPORTER_OTLP_ENDPOINT', 'http://otel-collector:4318/v1/traces'),
        // );

        // $tracerProvider = new TracerProvider(
        //     new SimpleSpanProcessor($exporter)
        // );

        // $this->app->instance(TracerProvider::class, $tracerProvider);
    }
}
