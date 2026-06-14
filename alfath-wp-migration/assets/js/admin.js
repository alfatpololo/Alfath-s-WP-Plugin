document.addEventListener('DOMContentLoaded', function() {
    const tabs = document.querySelectorAll('.nav-tab');
    const tabContents = document.querySelectorAll('.alfath-tab-content');

    tabs.forEach((tab, index) => {
        tab.addEventListener('click', (e) => {
            e.preventDefault();
            tabs.forEach(t => t.classList.remove('nav-tab-active'));
            tabContents.forEach(c => c.classList.remove('active'));
            tab.classList.add('nav-tab-active');
            tabContents[index].classList.add('active');
        });
    });

    // Export Logic
    const btnExport = document.getElementById('btn-start-export');
    const exportProgressWrapper = document.getElementById('export-progress-wrapper');
    const exportProgress = document.getElementById('export-progress');
    const exportStatus = document.getElementById('export-status');
    const exportDownloadWrapper = document.getElementById('export-download-wrapper');

    if (btnExport) {
        btnExport.addEventListener('click', async function() {
            btnExport.disabled = true;
            exportProgressWrapper.classList.remove('hidden');
            exportDownloadWrapper.classList.add('hidden');
            exportDownloadWrapper.innerHTML = '';
            
            const options = {
                export_db: document.getElementById('export_db').checked ? 1 : 0,
                export_uploads: document.getElementById('export_uploads').checked ? 1 : 0,
                export_themes: document.getElementById('export_themes').checked ? 1 : 0,
                export_plugins: document.getElementById('export_plugins').checked ? 1 : 0,
                export_mu_plugins: document.getElementById('export_mu_plugins').checked ? 1 : 0,
                exclude_cache: document.getElementById('exclude_cache').checked ? 1 : 0,
                exclude_backup: document.getElementById('exclude_backup').checked ? 1 : 0,
                exclude_node_modules: document.getElementById('exclude_node_modules').checked ? 1 : 0,
                exclude_git: document.getElementById('exclude_git').checked ? 1 : 0
            };

            let steps = [];
            if(options.export_db) steps.push({ action: 'export_database_step', label: 'Exporting Database...' });
            if(options.export_uploads) steps.push({ action: 'export_files_step', type: 'uploads', label: 'Exporting Uploads...' });
            if(options.export_themes) steps.push({ action: 'export_files_step', type: 'themes', label: 'Exporting Themes...' });
            if(options.export_plugins) steps.push({ action: 'export_files_step', type: 'plugins', label: 'Exporting Plugins...' });
            if(options.export_mu_plugins) steps.push({ action: 'export_files_step', type: 'mu-plugins', label: 'Exporting Must-Use Plugins...' });
            steps.push({ action: 'build_package', label: 'Building Package...' });

            try {
                let currentStep = 0;
                let downloadResult = null;

                for (let step of steps) {
                    exportStatus.innerText = step.label;
                    let progressPercent = Math.round((currentStep / steps.length) * 100);
                    exportProgress.style.width = progressPercent + '%';

                    let reqData = { ...options };
                    if (step.type) {
                        reqData.export_type = step.type;
                    }

                    let res = await performAjax(step.action, reqData);
                    if (!res.success) throw new Error(res.data || step.label + ' Failed');

                    if (step.action === 'build_package') {
                        downloadResult = res.data;
                    }
                    currentStep++;
                }

                exportStatus.innerText = 'Export Complete!';
                exportProgress.style.width = '100%';
                
                exportDownloadWrapper.innerHTML = `
                    <div class="notice notice-success inline" style="margin-bottom: 15px;">
                        <p>Package generated successfully: <strong>${downloadResult.file_name}</strong> (${downloadResult.file_size})</p>
                    </div>
                    <a href="${downloadResult.download_url}" class="button button-primary button-large" target="_blank">Download Package</a>
                `;
                exportDownloadWrapper.classList.remove('hidden');

            } catch (error) {
                exportStatus.innerText = 'Error: ' + error.message;
                exportProgress.style.background = 'red';
            } finally {
                btnExport.disabled = false;
            }
        });
    }

    // Import Logic
    const btnUpload = document.getElementById('btn-upload-import');
    const importFile = document.getElementById('import_file');
    const importDetails = document.getElementById('import-details-wrapper');
    const btnImport = document.getElementById('btn-start-import');
    const importProgressWrapper = document.getElementById('import-progress-wrapper');
    const importProgress = document.getElementById('import-progress');
    const importStatus = document.getElementById('import-status');
    
    let currentPackagePath = '';

    if (btnUpload) {
        btnUpload.addEventListener('click', async function() {
            const file = importFile.files[0];
            if (!file) {
                alert('Please select a file.');
                return;
            }

            btnUpload.disabled = true;

            const chunkSize = 2 * 1024 * 1024; // 2MB chunks
            const totalChunks = Math.ceil(file.size / chunkSize);
            const uniqueId = Date.now() + '_' + file.name;

            try {
                for (let i = 0; i < totalChunks; i++) {
                    const percent = Math.round((i / totalChunks) * 100);
                    btnUpload.innerText = `Uploading... ${percent}%`;
                    
                    const chunk = file.slice(i * chunkSize, (i + 1) * chunkSize);
                    const formData = new FormData();
                    formData.append('action', 'upload_import_chunk');
                    formData.append('nonce', alfathMigrationObj.nonce);
                    formData.append('chunk', chunk);
                    formData.append('chunk_index', i);
                    formData.append('total_chunks', totalChunks);
                    formData.append('file_id', uniqueId);
                    formData.append('file_name', file.name);

                    const response = await fetch(alfathMigrationObj.ajax_url, {
                        method: 'POST',
                        body: formData
                    });

                    let res;
                    try {
                        res = await response.json();
                    } catch (e) {
                        const text = await response.text();
                        console.error('Server response:', text);
                        throw new Error('Server rejected the upload. This is often caused by security firewalls or server upload limits (try increasing client_max_body_size or check error logs).');
                    }
                    
                    if (!res.success) {
                        throw new Error(res.data || 'Upload failed at chunk ' + i);
                    }

                    if (i === totalChunks - 1) {
                        currentPackagePath = res.data.package_path;
                        document.getElementById('source_url_display').innerText = res.data.manifest.site_url;
                        document.getElementById('old_url').value = res.data.manifest.site_url;
                        importDetails.classList.remove('hidden');
                        btnUpload.innerText = 'Uploaded & Validated';
                    }
                }
            } catch (error) {
                alert('Upload Error: ' + error.message);
                btnUpload.disabled = false;
                btnUpload.innerText = 'Upload and Validate';
            }
        });
    }

    if (btnImport) {
        btnImport.addEventListener('click', async function() {
            btnImport.disabled = true;
            importProgressWrapper.classList.remove('hidden');

            let steps = [
                { action: 'extract_package', label: 'Extracting Package...' },
                { action: 'import_database_step', label: 'Importing Database...' },
                { action: 'import_files_step', type: 'uploads', label: 'Restoring Uploads...' },
                { action: 'import_files_step', type: 'themes', label: 'Restoring Themes...' },
                { action: 'import_files_step', type: 'plugins', label: 'Restoring Plugins...' },
                { action: 'import_files_step', type: 'mu-plugins', label: 'Restoring Must-Use Plugins...' },
                { action: 'replace_urls_step', label: 'Replacing URLs & Cleaning Up...' }
            ];

            try {
                let currentStep = 0;
                let migrationToken = '';

                for (let step of steps) {
                    importStatus.innerText = step.label;
                    let progressPercent = Math.round((currentStep / steps.length) * 100);
                    importProgress.style.width = progressPercent + '%';

                    let reqData = { package_path: currentPackagePath };
                    if (migrationToken) {
                        reqData.migration_token = migrationToken;
                    }
                    if (step.action === 'replace_urls_step') {
                        reqData.old_url = document.getElementById('old_url').value;
                        reqData.new_url = document.getElementById('new_url').value;
                    }
                    if (step.action === 'import_files_step') {
                        reqData.import_type = step.type;
                    }

                    let res = await performAjax(step.action, reqData);
                    if (!res.success) throw new Error(res.data || step.label + ' Failed. Server Response: ' + JSON.stringify(res));
                    
                    if (step.action === 'extract_package' && res.data && res.data.migration_token) {
                        migrationToken = res.data.migration_token;
                    }

                    currentStep++;
                }

                importStatus.innerText = 'Import Complete! Please log in again if URLs changed.';
                importProgress.style.width = '100%';

            } catch (error) {
                importStatus.innerText = 'Error: ' + error.message;
                importProgress.style.background = 'red';
            } finally {
                btnImport.disabled = false;
            }
        });
    }

    // Backups Logic
    const deleteBtns = document.querySelectorAll('.btn-delete-backup');
    deleteBtns.forEach(btn => {
        btn.addEventListener('click', async function() {
            if (!confirm('Are you sure you want to delete this backup?')) return;
            
            const file = this.getAttribute('data-file');
            btn.disabled = true;
            btn.innerText = 'Deleting...';

            const formData = new FormData();
            formData.append('action', 'delete_backup');
            formData.append('nonce', alfathMigrationObj.nonce);
            formData.append('file', file);

            try {
                const response = await fetch(alfathMigrationObj.ajax_url, {
                    method: 'POST',
                    body: formData
                });
                
                const text = await response.text();
                let res;
                try {
                    res = JSON.parse(text);
                } catch (e) {
                    throw new Error('Invalid server response');
                }
                
                if (res.success) {
                    this.closest('tr').remove();
                } else {
                    throw new Error(res.data);
                }
            } catch (error) {
                alert('Error deleting backup: ' + error.message);
                btn.disabled = false;
                btn.innerText = 'Delete';
            }
        });
    });

    async function performAjax(action, extraData = {}) {
        const formData = new FormData();
        formData.append('action', action);
        formData.append('nonce', alfathMigrationObj.nonce);
        for (const key in extraData) {
            formData.append(key, extraData[key]);
        }

        const response = await fetch(alfathMigrationObj.ajax_url, {
            method: 'POST',
            body: formData
        });
        
        const text = await response.text();
        try {
            return JSON.parse(text);
        } catch (error) {
            console.error('AJAX Error Response:', text);
            throw new Error(`Invalid server response for action ${action}. Response: ${text.substring(0, 100)}`);
        }
    }
});
