<script>
    const state_invoice={
        'SUCCESS':"Hoàn thành",
        'WAITING':"Đang chờ",
        'ERROR':'Lỗi',
        'SENDING':'Đang gửi',
        'ACTIVE':'Kích hoạt',
        'INACTIVE':'Hủy kích hoạt',
    };

    const type_invoice={
        'IMPORT':'Nhập hàng',
        'INVOICE':'Bán hàng',
        'MOVE':'Chuyển hàng',
        'RECEIVE':'Nhận hàng',
        'RETURN':'Trả hàng',
        'RETURNIMPORT':'Trả hàng nhập',
    };
    const default_image="data:image/jpeg;base64,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AENsclNlbnVtAAAAAENsclMAAAAAUkdCQwAAAABJbnRlZW51bQAAAABJbnRlAAAAAENscm0AAAAATXBCbGJvb2wBAAAAD3ByaW50U2l4dGVlbkJpdGJvb2wAAAAAC3ByaW50ZXJOYW1lVEVYVAAAAAEAAAA4QklNBDsAAAAAAbIAAAAQAAAAAQAAAAAAEnByaW50T3V0cHV0T3B0aW9ucwAAABIAAAAAQ3B0bmJvb2wAAAAAAENsYnJib29sAAAAAABSZ3NNYm9vbAAAAAAAQ3JuQ2Jvb2wAAAAAAENudENib29sAAAAAABMYmxzYm9vbAAAAAAATmd0dmJvb2wAAAAAAEVtbERib29sAAAAAABJbnRyYm9vbAAAAAAAQmNrZ09iamMAAAABAAAAAAAAUkdCQwAAAAMAAAAAUmQgIGRvdWJAb+AAAAAAAAAAAABHcm4gZG91YkBv4AAAAAAAAAAAAEJsICBkb3ViQG/gAAAAAAAAAAAAQnJkVFVudEYjUmx0AAAAAAAAAAAAAAAAQmxkIFVudEYjUmx0AAAAAAAAAAAAAAAAUnNsdFVudEYjUHhsQFIAAAAAAAAAAAAKdmVjdG9yRGF0YWJvb2wBAAAAAFBnUHNlbnVtAAAAAFBnUHMAAAAAUGdQQwAAAABMZWZ0VW50RiNSbHQAAAAAAAAAAAAAAABUb3AgVW50RiNSbHQAAAAAAAAAAAAAAABTY2wgVW50RiNQcmNAWQAAAAAAADhCSU0D7QAAAAAAEABIAAAAAQACAEgAAAABAAI4QklNBCYAAAAAAA4AAAAAAAAAAAAAP4AAADhCSU0EDQAAAAAABAAAAB44QklNBBkAAAAAAAQAAAAeOEJJTQPzAAAAAAAJAAAAAAAAAAABADhCSU0nEAAAAAAACgABAAAAAAAAAAI4QklNA/UAAAAAAEgAL2ZmAAEAbGZmAAYAAAAAAAEAL2ZmAAEAoZmaAAYAAAAAAAEAMgAAAAEAWgAAAAYAAAAAAAEANQAAAAEALQAAAAYAAAAAAAE4QklNA/gAAAAAAHAAAP////////////////////////////8D6AAAAAD/////////////////////////////A+gAAAAA/////////////////////////////wPoAAAAAP////////////////////////////8D6AAA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YWJvdXQ9IiIgeG1sbnM6eG1wTU09Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9tbS8iIHhtbG5zOnN0UmVmPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvc1R5cGUvUmVzb3VyY2VSZWYjIiB4bWxuczpzdEV2dD0iaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wL3NUeXBlL1Jlc291cmNlRXZlbnQjIiB4bWxuczp4bXA9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC8iIHhtbG5zOmNycz0iaHR0cDovL25zLmFkb2JlLmNvbS9jYW1lcmEtcmF3LXNldHRpbmdzLzEuMC8iIHhtbG5zOnBob3Rvc2hvcD0iaHR0cDovL25zLmFkb2JlLmNvbS9waG90b3Nob3AvMS4wLyIgeG1sbnM6ZGM9Imh0dHA6Ly9wdXJsLm9yZy9kYy9lbGVtZW50cy8xLjEvIiB4bXBNTTpEb2N1bWVudElEPSJ4bXAuZGlkOjNGQ0UzNTdEODZBRjExRTU4Qzg4Q0JCQjZBNzQxOTBFIiB4bXBNTTpJbnN0YW5jZUlEPSJ4bXAuaWlkOjlFNEU3MzJBQ0VBREU3MTE5RDc0RUVEMzI4ODExNkQyIiB4bXBNTTpPcmlnaW5hbERvY3VtZW50SUQ9InhtcC5kaWQ6M0ZDRTM1N0Q4NkFGMTFFNThDODhDQkJCNkE3NDE5MEUiIHhtcDpDcmVhdG9yVG9vbD0iQWRvYmUgUGhvdG9zaG9wIENTNiAoTWFjaW50b3NoKSIgeG1wOkNyZWF0ZURhdGU9IjIwMTctMTAtMTBUMjI6MTU6NDUrMDc6MDAiIHhtcDpNb2RpZnlEYXRlPSIyMDE3LTEwLTEwVDIyOjE3OjQ0KzA3OjAwIiB4bXA6TWV0YWRhdGFEYXRlPSIyMDE3LTEwLTEwVDIyOjE3OjQ0KzA3OjAwIiBjcnM6QWxyZWFkeUFwcGxpZWQ9IlRydWUiIHBob3Rvc2hvcDpDb2xvck1vZGU9IjMiIGRjOmZvcm1hdD0iaW1hZ2UvanBlZyI+IDx4bXBNTTpEZXJpdmVkRnJvbSBzdFJlZjppbnN0YW5jZUlEPSJ4bXAuaWlkOjAxMDc5QzgzQkE4QzExRTI4OTU5RTAwMzg4MzI2QzJCIiBzdFJlZjpkb2N1bWVudElEPSJ4bXAuZGlkOjAxMDc5Qzg0QkE4QzExRTI4OTU5RTAwMzg4MzI2QzJCIi8+IDx4bXBNTTpIaXN0b3J5PiA8cmRmOlNlcT4gPHJkZjpsaSBzdEV2dDphY3Rpb249InNhdmVkIiBzdEV2dDppbnN0YW5jZUlEPSJ4bXAuaWlkOjlFNEU3MzJBQ0VBREU3MTE5RDc0RUVEMzI4ODExNkQyIiBzdEV2dDp3aGVuPSIyMDE3LTEwLTEwVDIyOjE3OjQ0KzA3OjAwIiBzdEV2dDpzb2Z0d2FyZUFnZW50PSJBZG9iZSBQaG90b3Nob3AgQ1M1IFdpbmRvd3MiIHN0RXZ0OmNoYW5nZWQ9Ii8iLz4gPC9yZGY6U2VxPiA8L3htcE1NOkhpc3Rvcnk+IDwvcmRmOkRlc2NyaXB0aW9uPiA8L3JkZjpSREY+IDwveDp4bXBtZXRhPiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIDw/eHBhY2tldCBlbmQ9InciPz7/7gAOQWRvYmUAZEAAAAAB/9sAhAACAgICAgICAgICAwICAgMEAwICAwQFBAQEBAQFBgUFBQUFBQYGBwcIBwcGCQkKCgkJDAwMDAwMDAwMDAwMDAwMAQMDAwUEBQkGBgkNCgkKDQ8ODg4ODw8MDAwMDA8PDAwMDAwMDwwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAz/wAARCABkAGQDAREAAhEBAxEB/90ABAAN/8QAdwABAQACAwEBAAAAAAAAAAAAAAkGCAQFBwECAQEAAAAAAAAAAAAAAAAAAAAAEAABAwIEAgQMBQUAAAAAAAAAAQIDBAURBgcIIRIxE9OVQVEicrMUdDVWF1cYYYG01DZxMlIVJREBAAAAAAAAAAAAAAAAAAAAAP/aAAwDAQACEQMRAD8ArQAAAAAAAAAAAAAAB//QrQAAAAAAAAAAAAAAB//RrQAAAAAAAAAAAAAAB//SrQAAAAAAAAAAAAAAB//TrQAAAagbotZ8/aUXLI1HkmahjTMVPWurWVlI2pc6SGWFkSM5nJy/3qn4geVLqhvaTgunk3cDO0AfNDez9PZu4GdoA+aG9n6ezdwM7QB80N7P09m7gZ2gGKZq3E7qcjwUk+b7FS5aiuLpGW+SvsrIkmfEiK9GeXxVqKiqBTajlfPRUM8mCyT00MsiomCcz42uXBP6qByQAAD/1K0AAAE8d8H8n0e82t/VUoFB66rpbfS1lwrZ2UtFQQyVNZUyLysjiiar3vcq9CI1FUDpcq5qsGdrBbs0ZYuMd1sl1j56SrjxRUVFwcyRi+Ux7F4Oa5MUUDI28quajlwaqpzL+HhA0T061P3AXfcLcMq5kttVHlRlZXRXWzyUCRUlvoYkk9XqIarq0VVXBmDlevWc3R4g6/fn7i009vunoYAN7bb7stfsVN6JoHNAAAP/1a0AAAE8d8H8n0f8yt/VUoGb7ztU0sGWaTTS01PLd83s9Yv6sXyobXG7BI1w6FqJG4ea13jA040J1xvGjeYFc5Jbnky8SNTMlhavH/FKqmRVwbMxPyenkr4FQNg9Q94dyt+qVBVZBlivenlmpmU9wt8rVjbdnz8sk0zXObzxOi4MjXDgqO5kVHAbyae6kZX1Qy5BmPKdxWqo1VI663yqjaminwxWGoixXlcngXocnFqqgGne/P3Fpp7fdPQwAb3W33Za/Yqb0TQOaAAAf//WrQAAATu3ySMizFpHLIvLHFFXySO6cGtqaVVX8kQDrNVZtsOq2c6zOlz1mu1oq6ympqV1DSWiaSJraWPq2qjpKfmxVOKgec/L7aj9eb/3M/8AbgPl9tR+vN/7mf8AtwM509k296YZigzLlPcRmClqm4R11FJZZHU1ZBjisNRH1CI5q+Belq8Wqigdfu31b0+1NtOR6fJF+/3M1nq6+W4s9XqIOrZNFE2NcZ42Y4q1egCmlt92Wv2Km9E0DmgAAH//160AAAHnGfdJNP8AU2a1z53sS3mWyxyxW1yVM8HVtnVrpEwhkZjirE6QMA+1TQX4HXvGu7cB9qmgvwOveNd24D7VNBfgde8a7twH2qaC/A69413bgfF2p6CqiouR1wXp/wCjXduBsJFGyGKKGNOWOFjY4m9ODWIjWpx8SIB+wAAD/9CtAAAAAAAAAAAAAAAH/9GtAAAAAAAAAAAAAAAH/9KtAAAAAAAAAAAAAAAH/9OtAAAAAAAAAAAAAAAH/9k=";
</script>