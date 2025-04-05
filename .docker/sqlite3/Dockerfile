FROM alpine:latest
 
# Install SQLite
RUN apk update && apk add sqlite
 
# Set the default working directory
WORKDIR /db
 
CMD ["sqlite3"]