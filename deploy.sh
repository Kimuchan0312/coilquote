#!/bin/bash
set -e

# ── Configuration ──────────────────────────────────────────────
PROJECT_ID="YOUR_GCP_PROJECT_ID"
REGION="asia-southeast1"          # Singapore — closest to Malaysia
SERVICE_NAME="coilquote"
IMAGE="gcr.io/$PROJECT_ID/$SERVICE_NAME"
# ───────────────────────────────────────────────────────────────

echo "Building and pushing Docker image..."
gcloud builds submit --tag "$IMAGE" .

echo "Deploying to Cloud Run..."
gcloud run deploy "$SERVICE_NAME" \
  --image "$IMAGE" \
  --platform managed \
  --region "$REGION" \
  --allow-unauthenticated \
  --port 8080 \
  --memory 512Mi \
  --cpu 1 \
  --min-instances 0 \
  --max-instances 3 \
  --set-env-vars "APP_ENV=production,APP_DEBUG=false,LOG_CHANNEL=stderr" \
  --set-secrets "APP_KEY=coilquote-app-key:latest,DB_PASSWORD=coilquote-db-password:latest"

echo ""
echo "Deploy complete. Service URL:"
gcloud run services describe "$SERVICE_NAME" --region "$REGION" --format "value(status.url)"
