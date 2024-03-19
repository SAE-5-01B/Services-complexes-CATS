#!/bin/bash

# Define the source and destination directories
SOURCE_DIR="./data_recuperer_SaveSync/data"
DESTINATION_DIR="../data"

# Ensure the source directory exists and is not empty
if [ -d "$SOURCE_DIR" ] && [ "$(ls -A $SOURCE_DIR)" ]; then
    echo "Restoring data from $SOURCE_DIR to $DESTINATION_DIR..."

    # Copying the contents from the backup directory to the data directory
    # The -a option preserves the specified attributes such as directory and file mode, ownership, and timestamps
    # The -v option makes the operation more talkative
    cp -av $SOURCE_DIR/* $DESTINATION_DIR/

    echo "Data restoration completed successfully."
else
    echo "Error: The source directory $SOURCE_DIR does not exist or is empty. Restoration aborted."
    exit 1
fi
