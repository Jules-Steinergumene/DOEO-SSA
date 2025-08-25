# Build stage
FROM node:22-alpine AS builder

WORKDIR /app

RUN apk add --no-cache libc6-compat

COPY package*.json ./

RUN npm ci --only=production && npm cache clean --force

COPY . .

RUN npm run build

# Production stage
FROM node:22-alpine AS production

RUN addgroup -g 1001 -S nodejs && \
    adduser -S nuxtjs -u 1001

WORKDIR /app

RUN apk add --no-cache dumb-init

COPY --from=builder --chown=nuxtjs:nodejs /app/.output ./

USER nuxtjs

EXPOSE 3000

ENTRYPOINT ["dumb-init", "--"]

CMD ["node", "server/index.mjs"]

# Development stage
FROM node:22-alpine AS development


# Set working directory
WORKDIR /app

# Install dependencies for development
RUN apk add --no-cache libc6-compat

# Copy package files
COPY package*.json ./

# Install all dependencies (including dev dependencies)
RUN npm ci

# Copy source code
COPY . .

# Expose port
EXPOSE 3000

# Start development server
CMD ["npm", "run", "dev"]
