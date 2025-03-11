#!/bin/bash

# CI4 Offline CDN Implementation Script
# This script automates the process of downloading CDN resources and configuring
# them for offline use in a CodeIgniter 4 project.
# 
# Usage: ./ci4_offline_setup.sh

# Exit on error
set -e

echo "===================================="
echo "  CI4 Offline CDN Implementation"
echo "===================================="
echo "This script will download CDN resources and set them up for offline use."
echo ""

# Define project root directory and asset paths
PROJECT_ROOT=$(pwd)
PUBLIC_DIR="$PROJECT_ROOT/public"
ASSETS_DIR="$PUBLIC_DIR/assets"
TEMP_DIR="$PROJECT_ROOT/temp_downloads"

# Version variables
BOOTSTRAP_VERSION="4.6.0"
JQUERY_VERSION="3.6.0"
FONTAWESOME_VERSION="5.15.3" 
SWEETALERT2_VERSION="11.0.0"
BS_CUSTOM_FILE_INPUT_VERSION="1.3.4"

# Create necessary directories
echo "Creating directory structure..."
mkdir -p "$ASSETS_DIR/css/bootstrap"
mkdir -p "$ASSETS_DIR/css/fontawesome"
mkdir -p "$ASSETS_DIR/css/sweetalert2"
mkdir -p "$ASSETS_DIR/js/bootstrap"
mkdir -p "$ASSETS_DIR/js/jquery"
mkdir -p "$ASSETS_DIR/js/fontawesome"
mkdir -p "$ASSETS_DIR/js/sweetalert2"
mkdir -p "$ASSETS_DIR/js/bs-custom-file-input"
mkdir -p "$ASSETS_DIR/fonts/source-sans-pro"
mkdir -p "$TEMP_DIR"

echo "Directory structure created successfully."

# Function to download a file
download_file() {
    local url=$1
    local destination=$2
    echo "Downloading: $url"
    curl -L --silent --show-error --fail "$url" -o "$destination" || {
        echo "❌ Failed to download: $url"
        echo "Trying alternative sources if available..."
        return 1
    }
    echo "✓ Downloaded to: $destination"
    return 0
}

# Download jQuery
echo ""
echo "Downloading jQuery $JQUERY_VERSION..."
download_file "https://code.jquery.com/jquery-$JQUERY_VERSION.min.js" "$ASSETS_DIR/js/jquery/jquery.min.js" || 
download_file "https://cdnjs.cloudflare.com/ajax/libs/jquery/$JQUERY_VERSION/jquery.min.js" "$ASSETS_DIR/js/jquery/jquery.min.js"

# Try to download the map file, but don't fail if it's not available
download_file "https://code.jquery.com/jquery-$JQUERY_VERSION.min.map" "$ASSETS_DIR/js/jquery/jquery.min.map" || true

# Download Bootstrap
echo ""
echo "Downloading Bootstrap $BOOTSTRAP_VERSION..."
download_file "https://cdn.jsdelivr.net/npm/bootstrap@$BOOTSTRAP_VERSION/dist/css/bootstrap.min.css" "$ASSETS_DIR/css/bootstrap/bootstrap.min.css" ||
download_file "https://cdnjs.cloudflare.com/ajax/libs/bootstrap/$BOOTSTRAP_VERSION/css/bootstrap.min.css" "$ASSETS_DIR/css/bootstrap/bootstrap.min.css"

# Try to download map files, but don't fail if not available
download_file "https://cdn.jsdelivr.net/npm/bootstrap@$BOOTSTRAP_VERSION/dist/css/bootstrap.min.css.map" "$ASSETS_DIR/css/bootstrap/bootstrap.min.css.map" || true

download_file "https://cdn.jsdelivr.net/npm/bootstrap@$BOOTSTRAP_VERSION/dist/js/bootstrap.bundle.min.js" "$ASSETS_DIR/js/bootstrap/bootstrap.bundle.min.js" ||
download_file "https://cdnjs.cloudflare.com/ajax/libs/bootstrap/$BOOTSTRAP_VERSION/js/bootstrap.bundle.min.js" "$ASSETS_DIR/js/bootstrap/bootstrap.bundle.min.js"

# Try to download map files, but don't fail if not available
download_file "https://cdn.jsdelivr.net/npm/bootstrap@$BOOTSTRAP_VERSION/dist/js/bootstrap.bundle.min.js.map" "$ASSETS_DIR/js/bootstrap/bootstrap.bundle.min.js.map" || true

# Download SweetAlert2
echo ""
echo "Downloading SweetAlert2 $SWEETALERT2_VERSION..."
download_file "https://cdn.jsdelivr.net/npm/sweetalert2@$SWEETALERT2_VERSION/dist/sweetalert2.min.css" "$ASSETS_DIR/css/sweetalert2/sweetalert2.min.css" ||
download_file "https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/$SWEETALERT2_VERSION/sweetalert2.min.css" "$ASSETS_DIR/css/sweetalert2/sweetalert2.min.css"

download_file "https://cdn.jsdelivr.net/npm/sweetalert2@$SWEETALERT2_VERSION/dist/sweetalert2.all.min.js" "$ASSETS_DIR/js/sweetalert2/sweetalert2.all.min.js" ||
download_file "https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/$SWEETALERT2_VERSION/sweetalert2.all.min.js" "$ASSETS_DIR/js/sweetalert2/sweetalert2.all.min.js"

# Download BS Custom File Input
echo ""
echo "Downloading BS Custom File Input $BS_CUSTOM_FILE_INPUT_VERSION..."
download_file "https://cdn.jsdelivr.net/npm/bs-custom-file-input@$BS_CUSTOM_FILE_INPUT_VERSION/dist/bs-custom-file-input.min.js" "$ASSETS_DIR/js/bs-custom-file-input/bs-custom-file-input.min.js" ||
download_file "https://cdnjs.cloudflare.com/ajax/libs/bs-custom-file-input/$BS_CUSTOM_FILE_INPUT_VERSION/bs-custom-file-input.min.js" "$ASSETS_DIR/js/bs-custom-file-input/bs-custom-file-input.min.js"

# Font Awesome implementation (updated for reliability)
echo ""
echo "Downloading Font Awesome $FONTAWESOME_VERSION..."

# Create Font Awesome directories
mkdir -p "$ASSETS_DIR/css/fontawesome/webfonts"
mkdir -p "$ASSETS_DIR/js/fontawesome" 

# Use cdnjs as our primary source for Font Awesome (more reliable)
FA_BASE_URL="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/$FONTAWESOME_VERSION"

# Download CSS
download_file "$FA_BASE_URL/css/all.min.css" "$ASSETS_DIR/css/fontawesome/all.min.css"

# Download JS (if needed)
download_file "$FA_BASE_URL/js/all.min.js" "$ASSETS_DIR/js/fontawesome/all.min.js" || true  # Optional

# Download individual webfonts
FA_WEBFONTS=(
  "fa-brands-400.eot"
  "fa-brands-400.svg"
  "fa-brands-400.ttf"
  "fa-brands-400.woff"
  "fa-brands-400.woff2"
  "fa-regular-400.eot"
  "fa-regular-400.svg"
  "fa-regular-400.ttf"
  "fa-regular-400.woff"
  "fa-regular-400.woff2"
  "fa-solid-900.eot"
  "fa-solid-900.svg"
  "fa-solid-900.ttf"
  "fa-solid-900.woff"
  "fa-solid-900.woff2"
)

echo "Downloading Font Awesome webfonts..."
for FONT in "${FA_WEBFONTS[@]}"; do
  download_file "$FA_BASE_URL/webfonts/$FONT" "$ASSETS_DIR/css/fontawesome/webfonts/$FONT" || true
done

# Fix font paths in the CSS file
echo "Updating Font Awesome CSS paths..."
if [ -f "$ASSETS_DIR/css/fontawesome/all.min.css" ]; then
  sed -i.bak "s|../webfonts/|./webfonts/|g" "$ASSETS_DIR/css/fontawesome/all.min.css" || true
  rm -f "$ASSETS_DIR/css/fontawesome/all.min.css.bak"
fi

# Download Source Sans Pro font
echo ""
echo "Downloading Source Sans Pro font..."
mkdir -p "$TEMP_DIR/source-sans-pro"

# Create the Source Sans Pro CSS file directly
echo "Creating Source Sans Pro CSS file..."
cat > "$ASSETS_DIR/fonts/source-sans-pro/source-sans-pro.css" << 'EOL'
/* Source Sans Pro - Self-hosted version */
@font-face {
  font-family: 'Source Sans Pro';
  font-style: normal;
  font-weight: 300;
  src: local('Source Sans Pro Light'), local('SourceSansPro-Light'),
       url('./source-sans-pro-light.woff2') format('woff2'),
       url('./source-sans-pro-light.woff') format('woff');
}

@font-face {
  font-family: 'Source Sans Pro';
  font-style: italic;
  font-weight: 300;
  src: local('Source Sans Pro Light Italic'), local('SourceSansPro-LightItalic'),
       url('./source-sans-pro-light-italic.woff2') format('woff2'),
       url('./source-sans-pro-light-italic.woff') format('woff');
}

@font-face {
  font-family: 'Source Sans Pro';
  font-style: normal;
  font-weight: 400;
  src: local('Source Sans Pro Regular'), local('SourceSansPro-Regular'),
       url('./source-sans-pro-regular.woff2') format('woff2'),
       url('./source-sans-pro-regular.woff') format('woff');
}

@font-face {
  font-family: 'Source Sans Pro';
  font-style: italic;
  font-weight: 400;
  src: local('Source Sans Pro Italic'), local('SourceSansPro-Italic'),
       url('./source-sans-pro-italic.woff2') format('woff2'),
       url('./source-sans-pro-italic.woff') format('woff');
}

@font-face {
  font-family: 'Source Sans Pro';
  font-style: normal;
  font-weight: 600;
  src: local('Source Sans Pro SemiBold'), local('SourceSansPro-SemiBold'),
       url('./source-sans-pro-semibold.woff2') format('woff2'),
       url('./source-sans-pro-semibold.woff') format('woff');
}

@font-face {
  font-family: 'Source Sans Pro';
  font-style: italic;
  font-weight: 600;
  src: local('Source Sans Pro SemiBold Italic'), local('SourceSansPro-SemiBoldItalic'),
       url('./source-sans-pro-semibold-italic.woff2') format('woff2'),
       url('./source-sans-pro-semibold-italic.woff') format('woff');
}

@font-face {
  font-family: 'Source Sans Pro';
  font-style: normal;
  font-weight: 700;
  src: local('Source Sans Pro Bold'), local('SourceSansPro-Bold'),
       url('./source-sans-pro-bold.woff2') format('woff2'),
       url('./source-sans-pro-bold.woff') format('woff');
}

@font-face {
  font-family: 'Source Sans Pro';
  font-style: italic;
  font-weight: 700;
  src: local('Source Sans Pro Bold Italic'), local('SourceSansPro-BoldItalic'),
       url('./source-sans-pro-bold-italic.woff2') format('woff2'),
       url('./source-sans-pro-bold-italic.woff') format('woff');
}
EOL

# Download source sans pro files from Google Fonts API
echo "Downloading Source Sans Pro font files..."

# We'll use Google Fonts CSS API to get the actual font files
FONT_CSS_URL="https://fonts.googleapis.com/css2?family=Source+Sans+Pro:ital,wght@0,300;0,400;0,600;0,700;1,300;1,400;1,600;1,700&display=swap"
download_file "$FONT_CSS_URL" "$TEMP_DIR/source-sans-pro/source-sans-pro-full.css"

# Function to extract and download font files
extract_and_download_fonts() {
    local css_file="$1"
    local output_dir="$2"
    
    if [ -f "$css_file" ]; then
        # Extract font URLs
        grep -o "https://[^)]*" "$css_file" | while read -r url; do
            # Extract file name from URL
            local filename
            # Remove URL query parameters for filename
            filename=$(basename "$url" | sed 's/\?.*//')
            
            # Map Google's naming to our naming convention
            case "$filename" in
                *-light.*)
                    new_filename="source-sans-pro-light.${filename##*.}"
                    ;;
                *-lightitalic.*)
                    new_filename="source-sans-pro-light-italic.${filename##*.}"
                    ;;
                *-regular.*)
                    new_filename="source-sans-pro-regular.${filename##*.}"
                    ;;
                *-italic.*)
                    new_filename="source-sans-pro-italic.${filename##*.}"
                    ;;
                *-semibold.*)
                    new_filename="source-sans-pro-semibold.${filename##*.}"
                    ;;
                *-semibolditalic.*)
                    new_filename="source-sans-pro-semibold-italic.${filename##*.}"
                    ;;
                *-bold.*)
                    new_filename="source-sans-pro-bold.${filename##*.}"
                    ;;
                *-bolditalic.*)
                    new_filename="source-sans-pro-bold-italic.${filename##*.}"
                    ;;
                *)
                    new_filename="source-sans-pro-${filename}"
                    ;;
            esac
            
            # Download the font file
            download_file "$url" "$output_dir/$new_filename" || true
        done
    else
        echo "Font CSS file not found: $css_file"
    fi
}

# Extract and download font files
extract_and_download_fonts "$TEMP_DIR/source-sans-pro/source-sans-pro-full.css" "$ASSETS_DIR/fonts/source-sans-pro"

# If the above doesn't work, download a backup set from cdnjs
if [ ! "$(ls -A "$ASSETS_DIR/fonts/source-sans-pro/" 2>/dev/null | grep -v source-sans-pro.css)" ]; then
    echo "Downloading backup Source Sans Pro files from cdnjs..."
    
    # Basic set of Source Sans Pro font files from cdnjs
    SOURCE_SANS_PRO_BASE_URL="https://cdnjs.cloudflare.com/ajax/libs/source-sans-pro/3.6.0"
    
    download_file "$SOURCE_SANS_PRO_BASE_URL/source-sans-pro-regular.woff" "$ASSETS_DIR/fonts/source-sans-pro/source-sans-pro-regular.woff" || true
    download_file "$SOURCE_SANS_PRO_BASE_URL/source-sans-pro-regular.woff2" "$ASSETS_DIR/fonts/source-sans-pro/source-sans-pro-regular.woff2" || true
    download_file "$SOURCE_SANS_PRO_BASE_URL/source-sans-pro-italic.woff" "$ASSETS_DIR/fonts/source-sans-pro/source-sans-pro-italic.woff" || true
    download_file "$SOURCE_SANS_PRO_BASE_URL/source-sans-pro-italic.woff2" "$ASSETS_DIR/fonts/source-sans-pro/source-sans-pro-italic.woff2" || true
    download_file "$SOURCE_SANS_PRO_BASE_URL/source-sans-pro-700.woff" "$ASSETS_DIR/fonts/source-sans-pro/source-sans-pro-bold.woff" || true
    download_file "$SOURCE_SANS_PRO_BASE_URL/source-sans-pro-700.woff2" "$ASSETS_DIR/fonts/source-sans-pro/source-sans-pro-bold.woff2" || true
    download_file "$SOURCE_SANS_PRO_BASE_URL/source-sans-pro-700italic.woff" "$ASSETS_DIR/fonts/source-sans-pro/source-sans-pro-bold-italic.woff" || true
    download_file "$SOURCE_SANS_PRO_BASE_URL/source-sans-pro-700italic.woff2" "$ASSETS_DIR/fonts/source-sans-pro/source-sans-pro-bold-italic.woff2" || true
fi

# Clean up temporary files
echo ""
echo "Cleaning up temporary files..."
rm -rf "$TEMP_DIR"

# Check for any missing essential files
echo ""
echo "Verifying downloads..."
MISSING_FILES=0

check_file() {
    if [ ! -f "$1" ]; then
        echo "⚠️ Missing essential file: $1"
        MISSING_FILES=$((MISSING_FILES + 1))
    fi
}

check_file "$ASSETS_DIR/css/bootstrap/bootstrap.min.css"
check_file "$ASSETS_DIR/js/bootstrap/bootstrap.bundle.min.js"
check_file "$ASSETS_DIR/js/jquery/jquery.min.js"
check_file "$ASSETS_DIR/css/fontawesome/all.min.css"
check_file "$ASSETS_DIR/js/sweetalert2/sweetalert2.all.min.js"
check_file "$ASSETS_DIR/css/sweetalert2/sweetalert2.min.css"
check_file "$ASSETS_DIR/fonts/source-sans-pro/source-sans-pro.css"

if [ $MISSING_FILES -gt 0 ]; then
    echo ""
    echo "⚠️ Warning: $MISSING_FILES essential files are missing."
    echo "Your offline implementation may not function correctly."
    echo "Please check the logs above for download errors and try again."
    echo "You may need to manually download some files."
else
    echo "✅ All essential files have been downloaded successfully."
fi

echo ""
echo "===================================="
echo "  Implementation Complete!"
echo "===================================="
echo ""
echo "CDN resources have been successfully downloaded and configured for offline use."
echo ""
echo "Next steps:"
echo "1. Update your template files to reference the local assets instead of CDN URLs."
echo "2. Test your application with the network disconnected to ensure it works offline."
echo ""
echo "Example usage in your views:"
echo "- CSS: <?= base_url('assets/css/bootstrap/bootstrap.min.css') ?>"
echo "- JS:  <?= base_url('assets/js/jquery/jquery.min.js') ?>"
echo ""
echo "Complete! Your CI4 project is now ready for offline use."

#!/bin/bash

# Source Sans Pro Font Fix Script
# This script resolves 404 errors for Source Sans Pro font files by directly downloading
# them from Google Fonts and correctly placing them in the assets directory.

# Exit on error
set -e

echo "===================================="
echo "  Source Sans Pro Font Fix"
echo "===================================="
echo ""

# Define project and asset paths
PUBLIC_DIR="./public"
ASSETS_DIR="$PUBLIC_DIR/assets"
FONTS_DIR="$ASSETS_DIR/fonts/source-sans-pro"
TEMP_DIR="./temp_downloads"

# Create directories if they don't exist
mkdir -p "$FONTS_DIR"
mkdir -p "$TEMP_DIR"

# Function to download a file
download_file() {
    local url=$1
    local destination=$2
    echo "Downloading: $url"
    curl -L --silent --show-error --fail "$url" -o "$destination" || {
        echo "❌ Failed to download: $url"
        return 1
    }
    echo "✓ Downloaded to: $destination"
    return 0
}

echo "Downloading Source Sans Pro fonts..."

# Direct approach: Use Google Fonts CDN with browser agent to get woff2 files
USER_AGENT="Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36"

# Download directly from the source - Google's CDN
FONT_BASE_URL="https://fonts.gstatic.com/s/sourcesanspro"

# Direct downloads for woff2 files (primary format for modern browsers)
download_file "$FONT_BASE_URL/v21/6xKydSBYKcSV-LCoeQqfX1RYOo3ig4vwlxdu.woff2" "$FONTS_DIR/source-sans-pro-bold.woff2"
download_file "$FONT_BASE_URL/v21/6xK3dSBYKcSV-LCoeQqfX1RYOo3qOK7l.woff2" "$FONTS_DIR/source-sans-pro-regular.woff2"
download_file "$FONT_BASE_URL/v21/6xKydSBYKcSV-LCoeQqfX1RYOo3i54rwlxdu.woff2" "$FONTS_DIR/source-sans-pro-semibold.woff2"
download_file "$FONT_BASE_URL/v21/6xKydSBYKcSV-LCoeQqfX1RYOo3i54rwlxdu.woff2" "$FONTS_DIR/source-sans-pro-600.woff2"
download_file "$FONT_BASE_URL/v21/6xKydSBYKcSV-LCoeQqfX1RYOo3ik4zwlxdu.woff2" "$FONTS_DIR/source-sans-pro-300.woff2"
download_file "$FONT_BASE_URL/v21/6xKydSBYKcSV-LCoeQqfX1RYOo3i54rwkxdu.woff2" "$FONTS_DIR/source-sans-pro-regular-italic.woff2"

# Download woff files as fallback for older browsers
download_file "$FONT_BASE_URL/v21/6xKydSBYKcSV-LCoeQqfX1RYOo3ig4vwlxdo.woff" "$FONTS_DIR/source-sans-pro-bold.woff"
download_file "$FONT_BASE_URL/v21/6xK3dSBYKcSV-LCoeQqfX1RYOo3qOK7j.woff" "$FONTS_DIR/source-sans-pro-regular.woff"
download_file "$FONT_BASE_URL/v21/6xKydSBYKcSV-LCoeQqfX1RYOo3i54rwlxdo.woff" "$FONTS_DIR/source-sans-pro-semibold.woff"
download_file "$FONT_BASE_URL/v21/6xKydSBYKcSV-LCoeQqfX1RYOo3i54rwlxdo.woff" "$FONTS_DIR/source-sans-pro-600.woff"
download_file "$FONT_BASE_URL/v21/6xKydSBYKcSV-LCoeQqfX1RYOo3ik4zwlxdo.woff" "$FONTS_DIR/source-sans-pro-300.woff"
download_file "$FONT_BASE_URL/v21/6xKydSBYKcSV-LCoeQqfX1RYOo3i54rwkxdo.woff" "$FONTS_DIR/source-sans-pro-regular-italic.woff"

# Fallback approach if Google's CDN fails
if [ ! -f "$FONTS_DIR/source-sans-pro-regular.woff2" ]; then
    echo "Falling back to alternative source..."
    
    # Use Font Squirrel or similar CDN as backup
    BACKUP_BASE_URL="https://use.fontawesome.com/releases/v5.15.4/webfonts"
    
    download_file "https://unpkg.com/@fontsource/source-sans-pro@4.5.0/files/source-sans-pro-latin-400-normal.woff2" "$FONTS_DIR/source-sans-pro-regular.woff2"
    download_file "https://unpkg.com/@fontsource/source-sans-pro@4.5.0/files/source-sans-pro-latin-700-normal.woff2" "$FONTS_DIR/source-sans-pro-bold.woff2"
    download_file "https://unpkg.com/@fontsource/source-sans-pro@4.5.0/files/source-sans-pro-latin-600-normal.woff2" "$FONTS_DIR/source-sans-pro-semibold.woff2"
    
    # Download woff fallbacks
    download_file "https://unpkg.com/@fontsource/source-sans-pro@4.5.0/files/source-sans-pro-latin-400-normal.woff" "$FONTS_DIR/source-sans-pro-regular.woff"
    download_file "https://unpkg.com/@fontsource/source-sans-pro@4.5.0/files/source-sans-pro-latin-700-normal.woff" "$FONTS_DIR/source-sans-pro-bold.woff"
    download_file "https://unpkg.com/@fontsource/source-sans-pro@4.5.0/files/source-sans-pro-latin-600-normal.woff" "$FONTS_DIR/source-sans-pro-semibold.woff"
fi

# Update CSS file to ensure it matches our font files
echo "Updating Source Sans Pro CSS file..."
cat > "$FONTS_DIR/source-sans-pro.css" << 'EOL'
/* Source Sans Pro - Local Assets Version */
@font-face {
  font-family: 'Source Sans Pro';
  font-style: normal;
  font-weight: 300;
  src: local('Source Sans Pro Light'), local('SourceSansPro-Light'),
       url('./source-sans-pro-300.woff2') format('woff2'),
       url('./source-sans-pro-300.woff') format('woff');
  font-display: swap;
}

@font-face {
  font-family: 'Source Sans Pro';
  font-style: normal;
  font-weight: 400;
  src: local('Source Sans Pro Regular'), local('SourceSansPro-Regular'),
       url('./source-sans-pro-regular.woff2') format('woff2'),
       url('./source-sans-pro-regular.woff') format('woff');
  font-display: swap;
}

@font-face {
  font-family: 'Source Sans Pro';
  font-style: italic;
  font-weight: 400;
  src: local('Source Sans Pro Italic'), local('SourceSansPro-Italic'),
       url('./source-sans-pro-regular-italic.woff2') format('woff2'),
       url('./source-sans-pro-regular-italic.woff') format('woff');
  font-display: swap;
}

@font-face {
  font-family: 'Source Sans Pro';
  font-style: normal;
  font-weight: 600;
  src: local('Source Sans Pro SemiBold'), local('SourceSansPro-SemiBold'),
       url('./source-sans-pro-semibold.woff2') format('woff2'),
       url('./source-sans-pro-semibold.woff') format('woff');
  font-display: swap;
}

@font-face {
  font-family: 'Source Sans Pro';
  font-style: normal;
  font-weight: 700;
  src: local('Source Sans Pro Bold'), local('SourceSansPro-Bold'),
       url('./source-sans-pro-bold.woff2') format('woff2'),
       url('./source-sans-pro-bold.woff') format('woff');
  font-display: swap;
}
EOL

# Verify files exist
echo ""
echo "Verifying font files..."
MISSING_FILES=0

check_file() {
    if [ ! -f "$1" ]; then
        echo "⚠️ Missing file: $1"
        MISSING_FILES=$((MISSING_FILES + 1))
    else
        echo "✅ Found: $1"
    fi
}

check_file "$FONTS_DIR/source-sans-pro-regular.woff2"
check_file "$FONTS_DIR/source-sans-pro-regular.woff"
check_file "$FONTS_DIR/source-sans-pro-bold.woff2"
check_file "$FONTS_DIR/source-sans-pro-bold.woff"
check_file "$FONTS_DIR/source-sans-pro-semibold.woff2"
check_file "$FONTS_DIR/source-sans-pro-semibold.woff"
check_file "$FONTS_DIR/source-sans-pro.css"

if [ $MISSING_FILES -gt 0 ]; then
    echo ""
    echo "⚠️ Warning: $MISSING_FILES font files are still missing."
    echo "Manual intervention may be needed."
    exit 1
else
    echo ""
    echo "✅ All font files have been successfully downloaded."
    echo ""
    echo "===================================="
    echo "  Source Sans Pro Fix Complete!"
    echo "===================================="
    echo ""
    echo "Your Source Sans Pro fonts should now work correctly."
    echo "Refresh your browser to verify the fix."
fi

# Clean up temporary files
rm -rf "$TEMP_DIR"

#!/bin/bash

# Additional Libraries Download Script for CI4 Offline Implementation
# This script extends the main ci4_offline_setup.sh by downloading additional
# required libraries like AdminLTE and Select2

# Exit on error
set -e

echo "===================================="
echo "  Additional Libraries Download"
echo "===================================="

# Define project root directory and asset paths
PROJECT_ROOT=$(pwd)
PUBLIC_DIR="$PROJECT_ROOT/public"
ASSETS_DIR="$PUBLIC_DIR/assets"
TEMP_DIR="$PROJECT_ROOT/temp_downloads"

# Version variables
ADMINLTE_VERSION="3.1.0"
SELECT2_VERSION="4.0.13"
SELECT2_BOOTSTRAP_VERSION="0.1.0-beta.10"

# Create necessary directories
echo "Creating directory structure for additional libraries..."
mkdir -p "$ASSETS_DIR/css/adminlte"
mkdir -p "$ASSETS_DIR/js/adminlte"
mkdir -p "$ASSETS_DIR/css/select2"
mkdir -p "$ASSETS_DIR/js/select2"
mkdir -p "$TEMP_DIR"

# Function to download a file (reused from main script)
download_file() {
    local url=$1
    local destination=$2
    echo "Downloading: $url"
    curl -L --silent --show-error --fail "$url" -o "$destination" || {
        echo "❌ Failed to download: $url"
        echo "Trying alternative sources if available..."
        return 1
    }
    echo "✓ Downloaded to: $destination"
    return 0
}

# Download AdminLTE
echo ""
echo "Downloading AdminLTE $ADMINLTE_VERSION..."
download_file "https://cdn.jsdelivr.net/npm/admin-lte@$ADMINLTE_VERSION/dist/css/adminlte.min.css" "$ASSETS_DIR/css/adminlte/adminlte.min.css" ||
download_file "https://cdnjs.cloudflare.com/ajax/libs/admin-lte/$ADMINLTE_VERSION/css/adminlte.min.css" "$ASSETS_DIR/css/adminlte/adminlte.min.css"

download_file "https://cdn.jsdelivr.net/npm/admin-lte@$ADMINLTE_VERSION/dist/js/adminlte.min.js" "$ASSETS_DIR/js/adminlte/adminlte.min.js" ||
download_file "https://cdnjs.cloudflare.com/ajax/libs/admin-lte/$ADMINLTE_VERSION/js/adminlte.min.js" "$ASSETS_DIR/js/adminlte/adminlte.min.js"

# Download Select2
echo ""
echo "Downloading Select2 $SELECT2_VERSION..."
download_file "https://cdn.jsdelivr.net/npm/select2@$SELECT2_VERSION/dist/css/select2.min.css" "$ASSETS_DIR/css/select2/select2.min.css" ||
download_file "https://cdnjs.cloudflare.com/ajax/libs/select2/$SELECT2_VERSION/css/select2.min.css" "$ASSETS_DIR/css/select2/select2.min.css"

download_file "https://cdn.jsdelivr.net/npm/select2@$SELECT2_VERSION/dist/js/select2.min.js" "$ASSETS_DIR/js/select2/select2.min.js" ||
download_file "https://cdnjs.cloudflare.com/ajax/libs/select2/$SELECT2_VERSION/js/select2.min.js" "$ASSETS_DIR/js/select2/select2.min.js"

# Download Select2 Bootstrap Theme
echo ""
echo "Downloading Select2 Bootstrap Theme $SELECT2_BOOTSTRAP_VERSION..."
download_file "https://cdn.jsdelivr.net/npm/@ttskch/select2-bootstrap4-theme@$SELECT2_BOOTSTRAP_VERSION/dist/select2-bootstrap4.min.css" "$ASSETS_DIR/css/select2/select2-bootstrap4.min.css" ||
download_file "https://cdnjs.cloudflare.com/ajax/libs/select2-bootstrap-theme/$SELECT2_BOOTSTRAP_VERSION/select2-bootstrap.min.css" "$ASSETS_DIR/css/select2/select2-bootstrap.min.css"

# For AdminLTE, we need to handle image paths
echo ""
echo "Processing AdminLTE CSS for local use..."
if [ -f "$ASSETS_DIR/css/adminlte/adminlte.min.css" ]; then
    # Create images directory for AdminLTE
    mkdir -p "$ASSETS_DIR/css/adminlte/img"
    
    # Download common AdminLTE images
    echo "Downloading AdminLTE images..."
    ADMINLTE_IMAGES=(
        "credit/american-express.png"
        "credit/cirrus.png"
        "credit/mastercard.png"
        "credit/paypal.png"
        "credit/visa.png"
    )
    
    for IMG in "${ADMINLTE_IMAGES[@]}"; do
        # Create directory structure if needed
        mkdir -p "$(dirname "$ASSETS_DIR/css/adminlte/img/$IMG")"
        
        # Try to download from CDN
        download_file "https://cdn.jsdelivr.net/npm/admin-lte@$ADMINLTE_VERSION/dist/img/$IMG" "$ASSETS_DIR/css/adminlte/img/$IMG" || 
        download_file "https://cdnjs.cloudflare.com/ajax/libs/admin-lte/$ADMINLTE_VERSION/img/$IMG" "$ASSETS_DIR/css/adminlte/img/$IMG" || true
    done
fi

# Verify downloads
echo ""
echo "Verifying additional downloads..."
MISSING_FILES=0

check_file() {
    if [ ! -f "$1" ]; then
        echo "⚠️ Missing file: $1"
        MISSING_FILES=$((MISSING_FILES + 1))
    else
        echo "✅ Found: $1"
    fi
}

check_file "$ASSETS_DIR/css/adminlte/adminlte.min.css"
check_file "$ASSETS_DIR/js/adminlte/adminlte.min.js"
check_file "$ASSETS_DIR/css/select2/select2.min.css"
check_file "$ASSETS_DIR/js/select2/select2.min.js"

if [ $MISSING_FILES -gt 0 ]; then
    echo ""
    echo "⚠️ Warning: $MISSING_FILES additional files are missing."
    echo "Manual intervention may be needed."
    exit 1
else
    echo ""
    echo "✅ All additional files have been successfully downloaded."
    echo ""
    echo "===================================="
    echo "  Additional Libraries Complete!"
    echo "===================================="
    echo ""
    echo "All required libraries are now available for offline use."
fi

# Clean up temporary directory
rm -rf "$TEMP_DIR"

#!/bin/bash

# Chart.js Offline Implementation Script
# This script downloads Chart.js and configures it for offline use in the CodeIgniter 4 project.

# Exit on error
set -e

echo "===================================="
echo "  Chart.js Offline Implementation"
echo "===================================="
echo ""

# Define project root directory and asset paths
PROJECT_ROOT=$(pwd)
PUBLIC_DIR="$PROJECT_ROOT/public"
ASSETS_DIR="$PUBLIC_DIR/assets"
JS_DIR="$ASSETS_DIR/js/chartjs"

# Version variables
CHARTJS_VERSION="4.4.0"  # Use the latest stable version or match your current version

# Create necessary directories
echo "Creating directory structure for Chart.js..."
mkdir -p "$JS_DIR"

# Function to download a file
download_file() {
    local url=$1
    local destination=$2
    echo "Downloading: $url"
    curl -L --silent --show-error --fail "$url" -o "$destination" || {
        echo "❌ Failed to download: $url"
        echo "Trying alternative sources if available..."
        return 1
    }
    echo "✓ Downloaded to: $destination"
    return 0
}

# Download Chart.js
echo ""
echo "Downloading Chart.js $CHARTJS_VERSION..."
download_file "https://cdn.jsdelivr.net/npm/chart.js@$CHARTJS_VERSION/dist/chart.umd.min.js" "$JS_DIR/chart.umd.min.js" || 
download_file "https://cdnjs.cloudflare.com/ajax/libs/Chart.js/$CHARTJS_VERSION/chart.umd.min.js" "$JS_DIR/chart.umd.min.js" ||
download_file "https://cdn.jsdelivr.net/npm/chart.js@$CHARTJS_VERSION/dist/chart.min.js" "$JS_DIR/chart.umd.min.js"

# Try to download map file, but don't fail if it's not available
download_file "https://cdn.jsdelivr.net/npm/chart.js@$CHARTJS_VERSION/dist/chart.umd.min.js.map" "$JS_DIR/chart.umd.min.js.map" || 
download_file "https://cdnjs.cloudflare.com/ajax/libs/Chart.js/$CHARTJS_VERSION/chart.umd.min.js.map" "$JS_DIR/chart.umd.min.js.map" || true

# Optional: Download additional Chart.js plugins if needed
echo ""
echo "Downloading Chart.js plugins..."

# Chart.js Data Labels plugin (optional but commonly used)
download_file "https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.2.0/dist/chartjs-plugin-datalabels.min.js" "$JS_DIR/chartjs-plugin-datalabels.min.js" || true

# Chart.js Annotation plugin
download_file "https://cdn.jsdelivr.net/npm/chartjs-plugin-annotation@2.1.2/dist/chartjs-plugin-annotation.min.js" "$JS_DIR/chartjs-plugin-annotation.min.js" || true

# Verify downloads
echo ""
echo "Verifying Chart.js downloads..."
if [ -f "$JS_DIR/chart.umd.min.js" ]; then
    echo "✅ Chart.js successfully downloaded!"
else
    echo "❌ Failed to download Chart.js. Manual intervention required."
    exit 1
fi

echo ""
echo "Creating Chart.js integration notes..."
cat > "$JS_DIR/README.md" << 'EOL'
# Chart.js Offline Implementation

## Integration Instructions

To use the offline version of Chart.js in your views:

1. Replace CDN references with local assets:

```php
// Replace this:
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

// With this:
<script src="<?= base_url('assets/js/chartjs/chart.umd.min.js') ?>"></script>
```

2. For optional plugins, include them after Chart.js:

```php
<script src="<?= base_url('assets/js/chartjs/chartjs-plugin-datalabels.min.js') ?>"></script>
```

## Version Information

- Chart.js: v4.4.0
- Downloaded: $(date '+%Y-%m-%d')

## Updating Chart.js

To update Chart.js to a newer version, run the download script again with the updated version number.
EOL

echo ""
echo "===================================="
echo "  Chart.js Implementation Complete!"
echo "===================================="
echo ""
echo "Chart.js has been successfully downloaded and is ready for offline use."
echo "Be sure to update any views that reference Chart.js to use the local version."
echo ""
echo "Example usage in your views:"
echo "<script src=\"<?= base_url('assets/js/chartjs/chart.umd.min.js') ?>\"></script>"
echo ""
echo "Complete! Chart.js is now available for offline use in your project."

